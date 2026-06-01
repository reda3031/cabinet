@extends('layouts.app')
@section('page-title', __('messages.add_doctor'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white font-weight-bold">
                {{ __('messages.add_doctor') }}
            </div>
            <div class="card-body">
                <form action="{{ route('admin.doctors.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>{{ __('messages.name') }}</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.email') }}</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.phone') }}</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.password') }}</label>
                        <input type="password" name="password" class="form-control" required minlength="6">
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.doctors') }}" class="btn btn-secondary">
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
