@extends('layouts.appLogin')
  
@section('content')
<div class="card-body">
      <p class="login-box-msg"></p>

      <form action="{{ route('login.post') }}" method="POST">
       @csrf
        <div class="input-group mb-3">
          <input type="text" id="email_address" class="form-control" name="email" placeholder="Email" required autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif
        <div class="input-group mb-3">
          <input type="password" id="password" class="form-control" name="password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        @if ($errors->has('password'))
                <span class="text-danger">{{ $errors->first('password') }}</span>
            @endif
        <div class="row">
          <div class="col-8">
            <!--div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div-->
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Login</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1">
        <a class="btn btn-link" href="{{route('resetpassword')}}"> {{ __('Forgot Your Password?') }}</a>
		<a class="btn btn-link float-right" href="{{route('register')}}"> {{ __('Agency SignUp') }}</a>
      </p>
	  <p class="mb-1">
        <a class="btn btn-link" target="_blank" href="{{route('privacyPolicy')}}"> {{ __('Privacy Policy') }}</a>
		<a class="btn btn-link float-right" target="_blank"  href="{{route('termsAndConditions')}}"> {{ __('Terms and Conditions') }}</a>
      </p>
    </div>
@endsection