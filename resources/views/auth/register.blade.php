@extends('layouts.app')

@section('content')
<div class="main">
    <div class="container">
        @if(\Session::has('failure'))
        <div class="alert alert-danger">
            <p class="m-0">{{\Session::get('failure')}}</p>
        </div>
        @endif
        <div class="signup-content">
            <div class="signup-form">
                <h1 class="form-title">Register</h1>
                <form method="POST" class="register-form" id="register-form" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <label for="nim" class="reg"><i class="fas fa-id-card" aria-hidden="true"></i></label>
                        <input id="nim" type="text" class="reg form-control @error('nbm_nim') is-invalid @enderror" name="nbm_nim" value="{{ old('nbm_nim') }}" autocomplete="nbm_nim" autofocus placeholder="NIM" />
                        @error('nbm_nim')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="username" class="reg"><i class="fas fa-user" aria-hidden="true"></i></label>
                        <input id="username" type="text" class="reg form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" autocomplete="username" autofocus placeholder="Username" />
                        @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="major" class="reg"><i class="fas fa-pencil-alt" aria-hidden="true"></i></label>
                        <select id="major" class="reg form-control @error('major') is-invalid @enderror" name="major" autocomplete="off">
                            <option value="" disable="true" selected="true">Pilih Program Studi</option>
                            <option value="sistem informasi" {{ old('major') == 'sistem informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                            <option value="teknik informatika" {{ old('major') == 'teknik informasi' ? 'selected' : '' }}>Teknik Informatika</option>
                        </select>
                        @error('major')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

            <div class="form-group">
                <label for="email" class="reg"><i class="fa fa-envelope" aria-hidden="true"></i></label>
                <input id="email" type="text" class="reg form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus placeholder="E-mail" />
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="pass" class="reg"><i class="fas fa-lock" aria-hidden="true"></i></label>
                <input id="password" type="password" class="reg form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" autocomplete="password" autofocus placeholder="Password" />
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label style="font-size: 17px; margin-top: 9px;" for="password-confirm" class="reg"><i class="zmdi zmdi-lock-outline"></i></label>
                <input id="password-confirm" type="password" class="reg form-control" name="password_confirmation" autocomplete="new-password" placeholder="Ulangi password" />
            </div>
            <div class="form-group form-button">
                <input type="submit" name="signup" id="signup" class="regsubmit form-submit" value="Register" />
            </div>
            </form>
        </div>
        <div class="signup-image">
            <figure><img class="img-fluid" src="{{ asset('asset/colorlib/images/signup-image.jpg')}}" alt="sing up image"></figure>
            <a href="{{ route('login')}}" class="signup-image-link">Saya sudah punya akun</a>
        </div>
    </div>
</div>
</div>
@endsection
<!-- This templates was made by Colorlib (https://colorlib.com) -->
<!-- Edited for own purposes by Rubi Chandraputra -->