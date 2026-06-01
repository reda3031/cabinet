@extends('layouts.app')
@section('page-title', __('messages.new_rdv'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white font-weight-bold">
                {{ __('messages.new_rdv') }}
            </div>
            <div class="card-body">
                <form action="{{ route('appointments.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>{{ __('messages.doctor') }}</label>
                        <select name="medecin_id" class="form-control" required>
                            <option value="">-- {{ __('messages.choose_doctor') }} --</option>
                            @foreach($medecins as $medecin)
                                <option value="{{ $medecin->id }}">{{ $medecin->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.service') }}</label>
                        <select name="service_id" class="form-control" required>
                            <option value="">-- {{ __('messages.choose_service') }} --</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.appointment_date') }}</label>
                        <input type="datetime-local" name="appointment_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.notes') }} <small class="text-muted">({{ __('messages.optional') }})</small></label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
                            {{ __('messages.back') }}
                        </a>
                        <button type="submit" class="btn btn-primary">
                            {{ __('messages.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
