@extends('layouts.app')

@section('content')
<header>
    <div class="jumbotron jumbotron-fluid jumbotron-custom bg-dark text-white m-0 no-select position-relative">
        <div class="bg-icons">
        </div>
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1 class="display-3 mb-0 text-white">Kamu lagi di beranda,</h1>
                    <p style="font-size: 1.2rem;">Tempat nongkrong dan belajar bareng!</p>
                </div>
            </div>
        </div>
    </div>
</header>
<article class="card-post my-5 no-select">
    <div class="container">
        <div id="ajax-holder" class="row">
            <input id="sum-data" type="hidden" value="{{ $sum_data }}">
            <input id="search-data" type="hidden" value="{{ $search }}">
            @foreach ($modul as $key)
            <div class="col-12 col-md-6 col-lg-4 mb-4 d-flex">
                <div class="card card-shadow rounded">
                    <a class="courses text-dark" href="{{ route('modul.show', $key->slug) }}">
                        <img class="card-img" src="{{ Storage::url($key->image) }}">
                        <div class="card-body">
                            <h4 class="card-title font-weight-bold mb-2">{{ $key->title }}</h4>
                           {{--  <div class="row">
                                <div class="col-6 mb-1">
                                    <span class="text-muted"><i class="fas fa-layer-group mr-2"></i>{{ $key->level }}</span>
                                </div>
                                <div class="col-6 mb-1">
                                    <span class="text-muted"><i class="fas fa-desktop mr-2"></i>{{ $key->platform }}</span>
                                </div>
                                <div class="col-6">
                                    <span class="text-muted"><i class="fas fa-bookmark mr-2"></i>{{ $key->lectures_count }} Materi</span>
                                </div>
                                <div class="col-6">
                                    <span class="text-muted"><i class="fas fa-user mr-2"></i>rubichandrap</span>
                                </div>
                            </div> --}}
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        <hr class=mt-5>
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="text-center">
                    <a id="show-link" class="btn shadow-none text-primary" href="#">Show more</a>
                </div>
            </div>
        </div>
    </div>
</article>
@endsection