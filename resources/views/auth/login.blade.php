@extends('layouts.template')
@section('title', 'Registro')
@section('styles')

<link rel="stylesheet" type="text/css" href="{{asset ("css/util.css")}}">
<link rel="stylesheet" type="text/css" href="{{asset ("css/main.css")}}">
@endsection
@section('content')
@if(Session::has('recover_message_done'))
<div class="alert alert-success" role="alert">
    {{ Session::get('recover_message_done') }}
</div>
@endif
@if(Session::has('recover_message_error'))
<div class="alert alert-danger" role="alert">
    {{ Session::get('recover_message_error') }}
</div>
@endif
	<div class="limiter" >
		<div class="container-login100" >
			<div class="wrap-login100" style="width: 50%;">
                <form method="POST" action="{{ route('login') }}" >
                    @csrf

                    <div class="form-group row ">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 offset-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Login') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('passwordreset') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>


@endsection