@extends('layouts.app')

@section('content')
<div class="main">
    <div class="container">
        @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li class="list-style-none">{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if(\Session::has('failure'))
        <div class="alert alert-danger">
            <p class="m-0">{{\Session::get('failure')}}</p>
        </div>
        @endif
        <div class="signin-content">
            <div class="signin-image">
                <figure><img class="img-fluid" src="{{ asset('asset/colorlib/images/signin-image.jpg') }}" alt="sing up image"></figure>
                <a href="{{ route('register')}}" class="signup-image-link">Buat akun</a>
            </div>

            <div class="signin-form">
                <h1 class="form-title">Login</h1>
                <form method="POST" class="register-form" id="login-form" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="login" class="reg"><i class="fa fa-user" aria-hidden="true"></i></label>
                        <input id="login" type="text" class="reg form-control {{ $errors->has('username') || $errors->has('email') ? 'is-invalid' : '' }}" name="login" value="{{ old('username') ?: old('email') }}" required autocomplete="login" autofocus placeholder="Username or E-mail" />
                        @if ($errors->has('username') || $errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="password" class="reg"><i class="fas fa-lock"></i></label>
                        <input id="password" type="password" class="reg form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password" />
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input class="reg form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                        <label for="remember" class="label-agree-term"><span><span></span></span>Ingat saya</label>
                    </div>
                    <div class="form-group form-button">
                        <input type="submit" name="signin" id="signin" class="regsubmit form-submit" value="Login" />
                        @if (Route::has('password.request'))
                        <a class="btn btn-link px-0" href="{{ route('password.request') }}">
                            {{ __('Lupa password?') }}
                        </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- This templates was made by Colorlib (https://colorlib.com) -->
<!-- Edited for own purposes by Rubi Chandraputra -->