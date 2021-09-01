@extends('layouts.app')

@section('content')
<header>
    <div class="container-fluid p-0 bg-gray-dark">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0 bg-transparent">
                    <li class="breadcrumb-item"><a class="text-white" href="{{ route('modul.index') }}">Modul</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="{{ route('modul.show', $modul->slug) }}">{{ $modul->title }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
                    <form id="form-edit" method="POST" action="{{ route('modul.update', $modul->id) }}" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PATCH" />
                        @csrf
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">Edit Modul</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <input id="btn-save" type="submit" class="btn btn-sm btn-primary" value="Simpan">
                                </div>
                            </div>
                        </div>
                        <div id="form-body" class="card-body">
                            <h6 class="heading-small text-muted mb-4">Informasi Modul</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6 mb-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-title">Title</label>
                                            <input class="form-control pl-2 @error('title') is-invalid @enderror" type="text" name="title" value="{{ $modul->title }}" placeholder="Masukkan Judul">
                                            @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3 mb-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-level">Level</label>
                                            <select class="form-control pl-2 @error('level') is-invalid @enderror" name="level">
                                                <option value="" {{ $modul->level == '' ? 'selected' : '' }}>Pilih level</option>
                                                <option value="Beginner" {{ $modul->level == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                                                <option value="Intermediate" {{ $modul->level == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                                                <option value="Expert" {{ $modul->level == 'Expert' ? 'selected' : '' }}>Expert</option>
                                            </select>
                                            @error('level')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3 mb-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-platform">Platform</label>
                                            <input class="form-control pl-2 @error('platform') is-invalid @enderror" type="text" name="platform" value="{{ $modul->platform }}" placeholder="Masukkan Platform">
                                            @error('platform')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-desc">Description</label>
                                            <textarea id="editor" name="desc" rows="4" class="form-control form-control-alternative @error('desc') is-invalid @enderror" placeholder="Deskripsikan apa saja yang akan dipelajari dalam modul ini...">{!! $modul->desc !!}</textarea>
                                            @error('desc')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-image">Image (Optional, Scale Recommendation 2:1)</label>
                                            <input class="form-control pl-2 @error('image') is-invalid @enderror" type="file" name="image" value="{{ $modul->image }}">
                                            @error('image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3 mb-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-status">Status</label>
                                            <select class="form-control pl-2 @error('status') is-invalid @enderror" name="status">
                                                {{-- <option value="" {{ $modul->status == '' ? 'selected' : '' }}>Pilih status</option> --}}
                                                <option value="0" {{ $modul->status == '0' ? 'selected' : '' }}>Hidden</option>
                                                <option value="1" {{ $modul->status == '1' ? 'selected' : '' }}>Published</option>
                                            </select>
                                            @error('status')
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