@extends('layouts.app')
@section('page-title', __('messages.patient_history'))

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.patients') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> {{ __('messages.back') ?? 'Retour' }}
    </a>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-1 font-weight-bold">{{ $user->name }}</h5>
            <div class="text-muted">
                <i class="fas fa-envelope mr-1"></i> {{ $user->email }}
                @if($user->phone)
                    <span class="mx-2">|</span>
                    <i class="fas fa-phone mr-1"></i> {{ $user->phone }}
                @endif
            </div>
        </div>
        <div>
            <span class="badge badge-primary">{{ ucfirst($user->role) }}</span>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead style="background:#f8fafc;">
                <tr>
                    <th>{{ __('messages.doctor') }}</th>
                    <th>{{ __('messages.service') }}</th>
                    <th>{{ __('messages.date') }}</th>
                    <th>{{ __('messages.status') }}</th>
                    <th>{{ __('messages.notes') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->medecin->name ?? '-' }}</td>
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
                    <td>{{ $appointment->notes ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">{{ __('messages.no_history') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
