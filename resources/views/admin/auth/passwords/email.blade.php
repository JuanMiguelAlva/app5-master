@extends('admin.auth.auth')
@section('content')
    <form method="POST" action="{{ route("admin.password.email") }}" class="needs-validation" novalidate>
        @csrf
        @if(session()->has('error'))
            <div class="alert alert-danger invalid-feedback d-block">{{ session()->get('error') }}</div>
        @endif
        @if(session()->has('message_sent'))
            <div class="alert alert-success invalid-feedback d-block">{{ session()->get('message_sent') }}</div>
        @else
        <label for="email" class="mb-1">{{ trans('admiko.email') }}:</label>
        <input type="text" class="form-control mb-1" required="true" id="email" name="email" placeholder="{{ trans('admiko.username') }}" value="{{ old('email') }}" autofocus>
        @if ($errors->has('email'))
            <div class="invalid-feedback d-block">{{ $errors->first('email') }}</div>
        @endif
        <div class="invalid-feedback">{{ trans('admiko.required_username') }}</div>
        <div class="row">
            <div class="mt-2">
                <button type="submit" class="btn btn-primary w-100">{{trans('admiko.reset_password_button')}}</button>
            </div>
        </div>
        @endif
    </form>
@endsection