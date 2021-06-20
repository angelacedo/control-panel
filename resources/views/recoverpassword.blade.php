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
                <p>Cambio de contraseña de {{app('request')->email}}</p>
				<form method="POST" action="{{route('password_recover_post', app('request')->email)}}">
					@csrf

					<div class="form-group row">
						<label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

						<div class="col-md-6">
							<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

							@error('password')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>
					</div>

					<div class="form-group row">
						<label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

						<div class="col-md-6">
							<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
						</div>
					</div>

					<div class="form-group row mb-0">
						<div class="col-md-6 offset-md-4">
							<button type="submit" class="btn btn-primary">
								{{ __('Register') }}
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>


@endsection