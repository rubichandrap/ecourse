@extends('layouts.app')

@section('content')
<!-- breadcrumb -->
<header>
    <div class="container-fluid p-0 bg-gray-dark">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0 bg-transparent">
                    <li class="breadcrumb-item"><a class="text-white" href="{{ route('mahasiswa.index') }}">Mahasiswa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $mahasiswa->name }}</li>
                </ol>
            </nav>
        </div>
    </div>
</header>
<article class="card-post my-5 no-select">
    <!-- Page content -->
    <div class="container">
            @if(\Session::has('success'))
            <div class="alert alert-success">
                <p class="m-0">{{\Session::get('success')}}</p>
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
                        <div class="d-flex justify-content-between">
                            <a href="#" target="_blank" class="btn btn-sm btn-info">Kirim Pesan</a>
                            <a href="mailto:{{ $mahasiswa->email }}" target="_blank" class="btn btn-sm btn-default float-right">Kirim Email</a>
                        </div>
                    </div>
                    <div class="card-body pt-2 pt-md-7 pt-lg-7">
                        <div class="text-center">
                            <h3>
                                {{ $mahasiswa->name }}
                            </h3>
                            <div class="h5 font-weight-300">
                                <i class="ni location_pin mr-2"></i>
                                @if(!$profile->alamat == '')
                                {{ $profile->alamat }}
                                @else
                                Belum Tersimpan
                                @endif
                            </div>
                            <div class="h5 mt-4">
                                <i class="ni business_briefcase-24 mr-2"></i>
                                @if(!$profile->pekerjaan == '')
                                {{ $profile->pekerjaan }}
                                @else
                                Belum Tersimpan
                                @endif
                            </div>
                            <div>
                                <i class="ni education_hat mr-2"></i>STMIK Muhammadiyah Jakarta
                            </div>
                            <hr class="my-4" />

                            <a href="#">Show more</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 order-xl-1">
                <div class="card bg-secondary shadow">

                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Detail akun</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a class="btn btn-sm btn-primary" href="{{route('mahasiswa.edit', $mahasiswa->id)}}">Edit User</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <h6 class="heading-small text-muted mb-4">Informasi User</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-nbm-nim">NIM</label>
                                        <input type="text" id="input-nbm-nim" class="form-control form-control-alternative" name="nbm_nim" value="{{ $mahasiswa->nbm_nim }}" placeholder="000001" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">Username</label>
                                        <input type="text" id="input-username" class="form-control form-control-alternative" name="username" value="{{ $mahasiswa->username}}" placeholder="johndoe" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-name">Nama</label>
                                        <input type="text" id="input-name" class="form-control form-control-alternative" name="name" value="{{ $mahasiswa->name }}" placeholder="John Doe" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-major">Major</label>
                                        <input type="text" id="input-major" class="form-control form-control-alternative" name="major" value="{{ $mahasiswa->majors->count() > 0 ? $mahasiswa->majors[0]->name : '-' }}" placeholder="Sistem Informasi" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">Email</label>
                                        <input type="text" id="input-email" class="form-control form-control-alternative" name="email" value="{{ $mahasiswa->email }}" placeholder="johndoe@example.com" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-status">Status</label>
                                        <input type="text" id="input-status" class="form-control form-control-alternative" name="status" value="{{ $mahasiswa->status == '1' ? 'Aktif' : 'Non-Aktif' }}" placeholder="Non-Aktif" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-role">Role</label>
                                        <input type="text" id="input-role" class="form-control form-control-alternative" name="role" value="{{ $mahasiswa->roles[0]->name }}" placeholder="Non-Aktif" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4" />
                        <!-- Address -->
                        <h6 class="heading-small text-muted mb-4">Informasi Tambahan</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-4 mb-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-pekerjaan">Pekerjaan</label>
                                        <input type="text" id="input-pekerjaan" class="form-control form-control-alternative" name="pekerjaan" value="{{ $profile->pekerjaan }}" placeholder="" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-tempatLahir">Tempat Lahir</label>
                                        <input type="text" id="input-tempat-lahir" class="form-control form-control-alternative" name="tempat_lahir" value="{{ $profile->tempat_lahir }}" placeholder="" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-tanggalLahir">Tanggal Lahir</label>
                                        <input type="text" id="input-tanggal-lahir" class="form-control form-control-alternative" name="tanggal_lahir" value="{{ $profile->tanggal_lahir }}" placeholder="" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-alamat">Alamat</label>
                                        <input type="text" id="input-alamat" class="form-control form-control-alternative" name="alamat" value="{{ $profile->alamat }}" placeholder="" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4" />
                        <!-- Description -->
                        <h6 class="heading-small text-muted mb-4">About me</h6>
                        <div class="pl-lg-4">
                            <div class="form-group">
                                <label class="form-control-label" for="about-me">About Me</label>
                                <textarea rows="4" class="form-control form-control-alternative mb-2" placeholder="A few words about you ..." readonly>{{ $profile->about }}</textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</article>


@endsection