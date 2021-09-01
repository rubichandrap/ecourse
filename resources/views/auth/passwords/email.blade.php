@extends('layouts.app')

@section('content')
<div class="main">
    <div class="container">
        <div class="forgot-password-content">
    <div class="forgot-password-image">
                <figure>
                    <img class="img-fluid" src="{{ asset('asset/colorlib/images/forgot-password.jpg') }}" alt="forgot password image">
                </figure>
            </div>
        <div class="forgot-password-form">
            
                <h1 class="form-title">{{ __('Reset Password') }}</h2>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email" class="reg"><i class="fa fa-envelope" aria-hidden="true"></i></label>
                                <input id="email" type="email" class="reg form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="E-mail Address">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group">
                            <div class="">
                                <button type="submit" class="btn btn-primary mb-2">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                            <div>
                                <a href="{{ route('login')}}">Kembali ke laman login</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>
    </div>
</div>
@endsection
