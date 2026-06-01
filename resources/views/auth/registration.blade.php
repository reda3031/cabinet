@extends('layouts.auth')
@section('auth-title', __('messages.register_title'))
@section('content')
<form action="{{ route('register.post') }}" method="POST">
    @csrf
    <div class="form-group">
        <label>{{ __('messages.name') }}</label>
        <input type="text" name="name" class="form-control" placeholder="{{ __('messages.name') }}" required>
    </div>
    <div class="form-group">
        <label>{{ __('messages.email') }}</label>
        <input type="email" name="email" class="form-control" placeholder="{{ __('messages.email') }}" required>
    </div>
    <div class="form-group">
        <label>{{ __('messages.phone') }}</label>
        <input type="text" name="phone" class="form-control" placeholder="{{ __('messages.phone') }}">
    </div>

    <div class="form-group">
        <label>{{ __('messages.password') }}</label>
        <input type="password" name="password" class="form-control" placeholder="{{ __('messages.password') }}" required>
    </div>
    <button type="submit" class="btn btn-primary btn-block">{{ __('messages.sign_up') }}</button>
</form>
<hr>
<p class="text-center mb-0">{{ __('messages.already_account') }} <a href="{{ route('login') }}">{{ __('messages.sign_in') }}</a></p>
@endsection