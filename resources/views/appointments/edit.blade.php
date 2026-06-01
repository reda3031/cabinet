@extends('layouts.app')
@section('page-title', __('messages.edit_appointment'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-warning text-white font-weight-bold">
                <i class="fas fa-edit"></i> {{ __('messages.edit_appointment') }}
            </div>
            <div class="card-body">
                <form action="{{ route('appointments.update', $appointment) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>{{ __('messages.doctor') }}</label>
                        <select name="medecin_id" class="form-control" required>
                            @foreach($medecins as $medecin)
                                <option value="{{ $medecin->id }}" {{ $appointment->medecin_id == $medecin->id ? 'selected' : '' }}>
                                    {{ $medecin->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.service') }}</label>
                        <select name="service_id" class="form-control" required>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ $appointment->service_id == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.appointment_date') }}</label>
                        <input type="datetime-local" name="appointment_date" class="form-control"
                            value="{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d\TH:i') }}" required>
                    </div>
                    @if(Auth::user()->role !== 'patient')
                    <div class="form-group">
                        <label>{{ __('messages.status') }}</label>
                        <select name="status" class="form-control" required>
                            <option value="pending"   {{ $appointment->status == 'pending'   ? 'selected' : '' }}>{{ __('messages.pending') }}</option>
                            <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>{{ __('messages.confirmed') }}</option>
                            <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>{{ __('messages.cancelled') }}</option>
                        </select>
                    </div>
                    @endif
                    <div class="form-group">
                        <label>{{ __('messages.notes') }}</label>
                        <textarea name="notes" class="form-control" rows="3">{{ $appointment->notes }}</textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> {{ __('messages.back') }}
                        </a>
                        <button type="submit" class="btn btn-warning text-white">
                            <i class="fas fa-save"></i> {{ __('messages.update') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection