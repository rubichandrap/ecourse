@extends('layouts.app')

@section('content')

<!-- breadcrumb -->
<header>
    <div class="container-fluid p-0 bg-gray-dark">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0 bg-transparent">
                    <li class="breadcrumb-item"><a class="text-white" href="{{ route('profile.index') }}">User profile</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ubah password</li>
                </ol>
            </nav>
        </div>
    </div>
</header>
<article class="card-post my-5 no-select">
    <!-- Page content -->
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
        <a class="d-inline-block pb-2" href="javascript:history.back()"><i class="fa fa-arrow-left mr-2"></i>Kembali</a>
        <div class="row">
            <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                <div class="card card-profile shadow">
                    <div class="row justify-content-center">
                        <div class="col-lg-3 order-lg-2">
                            <div class="card-profile-image">
                                <a href="#">
                                    <img src="{{ Storage::url($profile->image) }}" class="rounded-circle">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                    </div>
                    <div class="card-body pt-2 pt-md-7 pt-lg-7">
                        <div class="text-center">
                            <h3>
                                {{ $user->name }}
                            </h3>
                            <div class="h5 font-weight-300">
								<i class="fas fa-map-marked-alt mr-2"></i>
								@if(!$profile->alamat == '')
								{{ $profile->alamat }}
								@else
								Belum Tersimpan
								@endif
							</div>
							<div class="h5 mt-4">
								<i class="fas fa-business-time mr-2"></i>
								@if(!$profile->pekerjaan == '')
								{{ $profile->pekerjaan }}
								@else
								Belum Tersimpan
								@endif
							</div>
							<div>
								<i class="fas fa-graduation-cap mr-2"></i>STMIK Muhammadiyah Jakarta
							</div>
                            <hr class="my-4" />

                            <a href="#">Show more</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 order-xl-1">
                <div class="card bg-secondary shadow">
                    <form action="{{ route('password.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PATCH" />
                        @csrf
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <h3 class="mb-0">Ubah password</h3>
                                </div>
                                <div class="col-6 text-right">
                                    <input type="submit" class="btn btn-sm btn-primary" value="Simpan">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6 mb-2">
                                        <div class="form-group">
                                            <label class="form-control-label @error('username') is-invalid @enderror" for="input-username">Username</label>
                                            <input type="text" id="input-username" class="form-control @error('username') is-invalid @enderror form-control-alternative" name="username" placeholder="Masukkan Username" autocomplete="username">
                                            @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-current-password">Password Saat Ini</label>
                                            <input type="password" id="input-current-password" class="form-control form-control-alternative" name="current_password" placeholder="Masukkan Password Saat Ini" autocomplete="current-password">
                                            @error('current-password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-re-password">Password Baru</label>
                                            <input type="password" id="input-password" class="form-control form-control-alternative" name="password" placeholder="Masukkan Password Baru" autocomplete="password">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-re-password">Ketik Ulang</label>
                                            <input type="password" id="input-re-password" class="form-control form-control-alternative" name="password_confirmation" placeholder="Ketik Ulang Password Baru" autocomplete="new-password">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</article>

@endsection