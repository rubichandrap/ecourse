@extends('layouts.app')

@section('content')
<header>
    <div class="container-fluid p-0 bg-gray-dark">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0 bg-transparent">
                    <li class="breadcrumb-item"><a class="text-white" href="{{ route('home') }}">Beranda</a></li>
                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('dosen'))
                    <li class="breadcrumb-item"><a class="text-white" href="{{ route('modul.index') }}">Modul</a></li>
                    @endif
                    <li class="breadcrumb-item"><a class="text-white" href="{{ route('modul.show', $slug) }}">{{ $modul_title }}</a></li>
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
                <div class="card bg-secondary shadow">
                    <form method="POST" action="{{ route('lecture.store', $slug) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="modul_id" value="{{ $modul_id }}">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">Tambah Materi</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <input type="submit" class="btn btn-sm btn-primary" value="Simpan">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="heading-small text-muted mb-4">Informasi Materi</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6 mb-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-title">Title</label>
                                            <input class="form-control pl-2 @error('title') is-invalid @enderror" type="text" name="title" value="{{ old('title') }}" placeholder="Masukkan Judul">
                                            @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-content">Content</label>
                                            <textarea id="editor" name="content" rows="4" class="form-control form-control-alternative @error('content') is-invalid @enderror" placeholder="Deskripsikan apa saja yang akan dipelajari dalam modul ini...">{!! old('content') !!}</textarea>
                                            @error('content')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3 mb-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-status">Status (Default: Hidden)</label>
                                            <select class="form-control pl-2 @error('status') is-invalid @enderror" name="status">
                                                <option value="">Pilih status</option>
                                                <option value="0">Hidden</option>
                                                <option value="1">Published</option>
                                            </select>
                                            @error('level')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
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