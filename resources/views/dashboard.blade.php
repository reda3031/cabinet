@extends('layouts.app')

@section('page-title', __('messages.dashboard'))

@section('content')

@php
$userRole = Auth::user()->role;
@endphp

@if($userRole === 'admin')
<div class="row">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="text-muted" style="font-size:0.85rem">{{ __('messages.appointments') }}</div>
                <div class="font-weight-bold" style="font-size:1.5rem">{{ $totalAppointments }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="text-muted" style="font-size:0.85rem">{{ __('messages.patients') }}</div>
                <div class="font-weight-bold" style="font-size:1.5rem">{{ $totalPatients }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="text-muted" style="font-size:0.85rem">{{ __('messages.doctor') }}</div>
                <div class="font-weight-bold" style="font-size:1.5rem">{{ $totalMedecins }}</div>
            </div>
        </div>
    </div>
</div>
@else
<div class="row">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="text-muted" style="font-size:0.85rem">{{ __('messages.appointments') }}</div>
                <div class="font-weight-bold" style="font-size:1.5rem">{{ $totalAppointments }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="text-muted" style="font-size:0.85rem">{{ __('messages.pending') }}</div>
                <div class="font-weight-bold" style="font-size:1.5rem">{{ $pendingCount }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="text-muted" style="font-size:0.85rem">{{ __('messages.confirmed') }}</div>
                <div class="font-weight-bold" style="font-size:1.5rem">{{ $confirmedCount }}</div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead style="background:#f8fafc;">
                <tr>
                    @if($userRole === 'admin' || $userRole === 'medecin')
                        <th>{{ __('messages.patient') }}</th>
                    @endif
                    @if($userRole === 'admin' || $userRole === 'patient')
                        <th>{{ __('messages.doctor') }}</th>
                    @endif
                    <th>{{ __('messages.service') }}</th>
                    <th>{{ __('messages.date') }}</th>
                    <th>{{ __('messages.status') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lastAppointments as $appointment)
                <tr>
                    @if($userRole === 'admin' || $userRole === 'medecin')
                        <td>{{ $appointment->patient->name ?? '-' }}</td>
                    @endif
                    @if($userRole === 'admin' || $userRole === 'patient')
                        <td>{{ $appointment->medecin->name ?? '-' }}</td>
                    @endif
                    <td>{{ $appointment->service->name ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y H:i') }}</td>
                    <td>
                        @php
                            $badge = [
                                'pending'   => 'warning',
                                'confirmed' => 'success',
                                'cancelled' => 'danger',
                            ][$appointment->status] ?? 'secondary';
                        @endphp
                        <span class="badge badge-{{ $badge }}">{{ __('messages.'.$appointment->status) ?? ucfirst($appointment->status) }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">{{ __('messages.no_rdv') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
