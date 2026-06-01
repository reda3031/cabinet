@extends('layouts.auth')
@section('auth-title', __('messages.login_title'))
@section('content')
<form action="{{ route('login.post') }}" method="POST">
    @csrf
    <div class="form-group">
        <label>{{ __('messages.email') }}</label>
        <input type="email" name="email" class="form-control" placeholder="{{ __('messages.email') }}" required autofocus>
    </div>
    <div class="form-group">
        <label>{{ __('messages.password') }}</label>
        <input type="password" name="password" class="form-control" placeholder="{{ __('messages.password') }}" required>
    </div>
    <button type="submit" class="btn btn-primary btn-block">{{ __('messages.sign_in') }}</button>
</form>
<hr>
<p class="text-center mb-0">{{ __('messages.no_account') }} <a href="{{ route('register') }}">{{ __('messages.sign_up') }}</a></p>
@endsection