<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentApiController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['patient', 'medecin', 'service'])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $appointments
        ]);
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'medecin', 'service']);

        return response()->json([
            'success' => true,
            'data'    => $appointment
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id'       => 'required|exists:users,id',
            'medecin_id'       => 'required|exists:users,id',
            'service_id'       => 'required|exists:services,id',
            'appointment_date' => 'required|date',
            'status'           => 'in:pending,confirmed,cancelled',
            'notes'            => 'nullable|string',
        ]);

        $appointment = Appointment::create($request->all());
        $appointment->load(['patient', 'medecin', 'service']);

        return response()->json([
            'success' => true,
            'message' => 'Rendez-vous créé avec succès',
            'data'    => $appointment
        ], 201);
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'medecin_id'       => 'exists:users,id',
            'service_id'       => 'exists:services,id',
            'appointment_date' => 'date',
            'status'           => 'in:pending,confirmed,cancelled',
            'notes'            => 'nullable|string',
        ]);

        $appointment->update($request->all());
        $appointment->load(['patient', 'medecin', 'service']);

        return response()->json([
            'success' => true,
            'message' => 'Rendez-vous mis à jour avec succès',
            'data'    => $appointment
        ]);
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rendez-vous supprimé avec succès'
        ]);
    }
}