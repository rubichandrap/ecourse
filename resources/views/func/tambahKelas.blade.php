@extends('layouts.app')

@section('content')
<header>
    <div class="container-fluid p-0 bg-gray-dark">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0 bg-transparent">
                    <li class="breadcrumb-item"><a class="text-white" href="{{ route('kelas.index') }}">Kelas</a></li>
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
                    <form method="POST" action="{{ route('kelas.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">Tambah Kelas</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <input type="submit" class="btn btn-sm btn-primary" value="Simpan">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="heading-small text-muted mb-4">Informasi Kelas</h6>
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
                                    <div class="col-lg-3 mb-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-sessions">Sessions</label>
                                            <input class="form-control pl-2 @error('sessions') is-invalid @enderror" type="number" min="0" max="10" name="sessions" value="{{ old('sessions') }}" placeholder="0">
                                            @error('sessions')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-desc">Description</label>
                                            <textarea id="editor" name="desc" rows="4" class="form-control form-control-alternative @error('desc') is-invalid @enderror" placeholder="Deskripsikan apa saja yang akan dipelajari dalam kelas ini...">{{ old('desc') }}</textarea>
                                            @error('desc')
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