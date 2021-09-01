@extends('layouts.app')

@section('content')
<!-- breadcrumb -->
<header>
    <div class="container-fluid p-0 bg-gray-dark">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0 bg-transparent">
                    <li class="breadcrumb-item"><a class="text-white" href="{{ route('mahasiswa.index') }}">Mahasiswa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add</li>
                </ol>
            </nav>
        </div>
    </div>
</header>
<article class="card-post my-5 no-select">
    <div class="container">
        @if(\Session::has('failure'))
            <div class="alert alert-danger">
                <p class="m-0">{{\Session::get('failure')}}</p>
            </div>
        @endif
        <a class="d-inline-block pb-2" href="javascript:history.back()"><i class="fa fa-arrow-left mr-2"></i>Kembali</a>
        <div class="row">
            <div class="col-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h3 class="card-title">Tambah Mahasiswa</h3>
                        <form method="POST" action="{{ route('mahasiswa.store') }}">
                            @csrf
                            <div class="table-responsive">
                                <table class="mb-0 table align-items-center">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>NIM</th>
                                            <th>Name</th>
                                            <th>Major</th>
                                            <th>Email</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input class="form-control cstm pl-2 @error('nbm_nim') is-invalid @enderror" type="text" name="nbm_nim" value="{{ old('nbm_nim') }}" placeholder="Masukkan NIM">
                                                @error('nbm_nim')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </td>
                                            <td><input class="form-control cstm pl-2 @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama Lengkap">
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <select class="form-control cstm pl-2 @error('major') is-invalid @enderror" name="major">
                                                    <option value="" {{ old('major') == '' ? 'selected' : '' }}>Pilih Major</option>
                                                    <option value="sistem informasi" {{ old('major') == 'sistem informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                                                    <option value="teknik informatika" {{ old('major') == 'teknik informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                                                </select>
                                                @error('major')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </td>
                                            <td><input class="form-control cstm pl-2 @error('email') is-invalid @enderror" type="text" name="email" value="{{ old('email') }}" placeholder="Masukkan Email">
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>
                                                        <input class="btn btn-primary" type="submit" value="Add">
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>
@endsection