<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\AppointmentConfirmed;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $data = [];

        if ($user->role === 'admin') {
            $data['totalAppointments'] = Appointment::count();
            $data['totalPatients'] = User::where('role', 'patient')->count();
            $data['totalMedecins'] = User::where('role', 'medecin')->count();
            $data['totalServices'] = Service::count();
            $data['lastAppointments'] = Appointment::with(['patient', 'medecin', 'service'])
                ->latest()
                ->take(5)
                ->get();
        } elseif ($user->role === 'medecin') {
            $query = Appointment::where('medecin_id', $user->id);
            $data['totalAppointments'] = (clone $query)->count();
            $data['pendingCount'] = (clone $query)->where('status', 'pending')->count();
            $data['confirmedCount'] = (clone $query)->where('status', 'confirmed')->count();
            $data['lastAppointments'] = Appointment::where('medecin_id', $user->id)
                ->with(['patient', 'service'])
                ->latest()
                ->take(5)
                ->get();
        } elseif ($user->role === 'patient') {
            $query = Appointment::where('patient_id', $user->id);
            $data['totalAppointments'] = (clone $query)->count();
            $data['pendingCount'] = (clone $query)->where('status', 'pending')->count();
            $data['confirmedCount'] = (clone $query)->where('status', 'confirmed')->count();
            $data['lastAppointments'] = Appointment::where('patient_id', $user->id)
                ->with(['medecin', 'service'])
                ->latest()
                ->take(5)
                ->get();
        }

        return view('dashboard', $data);
    }

    public function index()
    {
        $user = Auth::user();
        
        $query = Appointment::with(['patient', 'medecin', 'service']);

        if ($user->role === 'medecin') {
            $query->where('medecin_id', $user->id);
        } elseif ($user->role === 'patient') {
            $query->where('patient_id', $user->id);
        }

        $appointments = $query->latest()->paginate(10);

        $medecins = User::where('role', 'medecin')->get();
        $services = Service::all();

        return view('appointments.index', compact('appointments', 'medecins', 'services'));
    }

    public function create()
    {
        if (Auth::user()->role === 'medecin') {
            return redirect()->route('appointments.index')
                ->with('error', 'Les médecins ne peuvent pas créer de rendez-vous.');
        }

        $medecins = User::where('role', 'medecin')->get();
        $services = Service::all();
        return view('appointments.create', compact('medecins', 'services'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role === 'medecin') {
            return redirect()->route('appointments.index')
                ->with('error', 'Les médecins ne peuvent pas créer de rendez-vous.');
        }

        $request->validate([
            'medecin_id'       => 'required|exists:users,id',
            'service_id'       => 'required|exists:services,id',
            'appointment_date' => 'required|date|after:now',
            'notes'            => 'nullable|string|max:500',
        ]);

        $appointment = Appointment::create([
            'patient_id'       => Auth::id(),
            'medecin_id'       => $request->medecin_id,
            'service_id'       => $request->service_id,
            'appointment_date' => $request->appointment_date,
            'notes'            => $request->notes,
            'status'           => 'pending',
        ]);
        // Charger les relations pour l'email
        $appointment->load(['patient', 'medecin', 'service']);
        // Envoi email de confirmation
        Mail::to(Auth::user()->email)->send(new AppointmentConfirmed($appointment));
        return redirect()->route('appointments.index')
            ->with('success', 'Rendez-vous créé avec succès !');
    }

    public function edit(Appointment $appointment)
    {
        $medecins = User::where('role', 'medecin')->get();
        $services = Service::all();
        return view('appointments.edit', compact('appointment', 'medecins', 'services'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $user = Auth::user();

        if ($user->role === 'patient') {
            if ($appointment->patient_id !== $user->id) {
                return redirect()->route('appointments.index')
                    ->with('error', 'Vous ne pouvez pas modifier ce rendez-vous.');
            }

            $request->validate([
                'medecin_id'       => 'required|exists:users,id',
                'service_id'       => 'required|exists:services,id',
                'appointment_date' => 'required|date',
                'notes'            => 'nullable|string|max:500',
            ]);

            $appointment->update($request->only(['medecin_id', 'service_id', 'appointment_date', 'notes']));
        } else {
            $request->validate([
                'medecin_id'       => 'required|exists:users,id',
                'service_id'       => 'required|exists:services,id',
                'appointment_date' => 'required|date',
                'status'           => 'required|in:pending,confirmed,cancelled',
                'notes'            => 'nullable|string|max:500',
            ]);

            $appointment->update($request->all());
        }

        return redirect()->route('appointments.index')
            ->with('success', 'Rendez-vous mis à jour avec succès !');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')
            ->with('success', 'Rendez-vous annulé avec succès !');
    }

    public function show(Appointment $appointment)
    {
        return redirect()->route('appointments.index');
    }
    public function search(Request $request)
    {
        $user = Auth::user();
        $queryText = $request->get('q', '');

        $query = Appointment::with(['patient', 'medecin', 'service']);

        if ($user->role === 'medecin') {
            $query->where('medecin_id', $user->id);
        } elseif ($user->role === 'patient') {
            $query->where('patient_id', $user->id);
        }

        $appointments = $query->where(function($q) use ($queryText) {
            $q->whereHas('patient', fn($subQ) => $subQ->where('name', 'like', "%$queryText%"))
              ->orWhereHas('medecin', fn($subQ) => $subQ->where('name', 'like', "%$queryText%"))
              ->orWhereHas('service', fn($subQ) => $subQ->where('name', 'like', "%$queryText%"));
        })->latest()->get();

        return response()->json($appointments);
    }
}
