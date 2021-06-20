@extends('layouts.template')
@section('title', 'Registro')
@section('styles')

<link rel="stylesheet" type="text/css" href="{{asset ("css/util.css")}}">
<link rel="stylesheet" type="text/css" href="{{asset ("css/main.css")}}">
@endsection
@section('content')

	<div class="limiter" >
		<div class="container-login100" >
			<div class="wrap-login100" style="width: 50%;">
                {{--Email flash message--}}
                @if(Session::has('reset_email_message'))
                <div class="alert alert-success" role="alert">
                {{Session::get('reset_email_message')}}
                </div>
                @endif
                <form method="POST" action="{{ route('passwordreset_email') }}" >
                    @csrf
                    <p class="text-center">Al introducir su email, se le enviará un correo electronico <br> para que pueda restaurar su contraseña</p>
                    <br>
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

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Send Email') }}
                            </button>
                        </div>
                    </div>
                </form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>


@endsection