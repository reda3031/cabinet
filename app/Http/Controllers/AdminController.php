<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function doctors()
    {
        $doctors = User::where('role', 'medecin')->get();
        return view('admin.doctors', compact('doctors'));
    }

    public function createDoctor()
    {
        return view('admin.create-doctor');
    }

    public function storeDoctor(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'medecin',
        ]);

        return redirect()->route('admin.doctors')->with('success', __('messages.doctor_created'));
    }

    public function destroyDoctor(User $user)
    {
        if ($user->role === 'medecin') {
            $user->delete();
            return redirect()->route('admin.doctors')->with('success', __('messages.doctor_deleted'));
        }
        
        return redirect()->route('admin.doctors')->with('error', 'Action non autorisée.');
    }

    public function patients()
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $patients = User::where('role', 'patient')
            ->withCount('appointmentsAsPatient')
            ->get();
        return view('admin.patients', compact('patients'));
    }

    public function patientHistory(User $user)
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $appointments = $user->appointmentsAsPatient()
            ->with(['medecin', 'service'])
            ->latest()
            ->get();
        return view('admin.patient-history', compact('user', 'appointments'));
    }

    public function searchDoctors(Request $request)
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $query = $request->get('q', '');
        $doctors = User::where('role', 'medecin')
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%$query%")
                  ->orWhere('email', 'like', "%$query%")
                  ->orWhere('phone', 'like', "%$query%");
            })
            ->get();
        return response()->json($doctors);
    }

    public function searchPatients(Request $request)
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $query = $request->get('q', '');
        $patients = User::where('role', 'patient')
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%$query%")
                  ->orWhere('email', 'like', "%$query%")
                  ->orWhere('phone', 'like', "%$query%");
            })
            ->withCount('appointmentsAsPatient')
            ->get();
        return response()->json($patients);
    }
}
