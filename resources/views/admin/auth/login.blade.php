@extends('admin.auth.auth')
@section('content')
    <form method="POST" action="{{ route("admin.login") }}" class="needs-validation" novalidate>
        @csrf
        @if(session()->has('error'))
            <div class="alert alert-danger invalid-feedback d-block">{{ session()->get('error') }}</div>
        @endif
        <label for="email" class="mb-1">{{ trans('admiko.email') }}:</label>
        <input type="text" class="form-control mb-1" required="true" id="email" name="email" placeholder="{{ trans('admiko.username') }}" value="{{ old('email') }}" autofocus>
        @if ($errors->has('email'))
            <div class="invalid-feedback d-block">{{ $errors->first('email') }}</div>
        @endif
        <div class="invalid-feedback">{{ trans('admiko.required_username') }}</div>
        <label for="password" class="mb-1">{{ trans('admiko.password') }}:</label>
        <input type="password" class="form-control mb-1" id="password" required="true" name="password" placeholder="{{ trans('admiko.password') }}">
        @if ($errors->has('password'))
            <div class="invalid-feedback d-block">{{ $errors->first('password') }}</div>
        @endif
        <div class="invalid-feedback">
            {{ trans('admiko.required_password') }}
        </div>
        <small><a href="{{ route("admin.password.request") }}">{{ trans('admiko.forgot_pass') }}</a></small>
        <div class="form-check my-2">
            <input class="form-check-input" type="checkbox" value="1" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">
                {{ trans('admiko.remember_me') }}
            </label>
        </div>
        <div class="row">
            <div>
                <button type="submit" class="btn btn-primary w-100">{{ trans('admiko.login_button') }}</button>
            </div>
        </div>
    </form>
@endsection