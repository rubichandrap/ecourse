@extends('layouts.app')

@section('content')
<!-- breadcrumb -->
<header>
    <div class="container-fluid p-0 bg-gray-dark">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0 bg-transparent">
                    <li class="breadcrumb-item"><a class="text-white" href="{{ route('home') }}">Beranda</a></li>
                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('dosen'))
                    <li class="breadcrumb-item"><a class="text-white" href="{{ route('modul.index') }}">Modul</a></li>
                    @endif
                    <li class="breadcrumb-item">
                        <a class="text-white" href="{{ route('modul.show', $modul->slug) }}">
                            {{$modul->title}}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $detail->title }}</li>
                </ol>
            </nav>
        </div>
    </div>
</header>
<!-- content -->
<section class="section-divider no-select">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 d-none d-lg-block pb-5">
                <h2>Daftar Modul</h2>
                <div class="form-inline my-4">
                    <div id="search-form" class="js-live-search form-inline mb-0 mr-2 w-100">
                        <input class="form-control mr-2 w-75" type="text" placeholder="Cari Materi" name="search_input_materi" value="{{old('search_input_materi')}}" />
                        <div class="p-2">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                </div>
                <ul class="js-live-search-list list-group">
                    @foreach($lecture as $key)
                    <li class="{{ request()->is('modul/*/lecture/'.$key->urutan) ? 'active disabled' : '' }} list-group-item d-flex justify-content-between align-items-center">
                        <a class="{{ request()->is('modul/*/lecture/'.$key->urutan) ? 'text-white' : '' }}" href="{{ route('lecture.show', [$modul->slug, $key->urutan]) }}">
                            {{ $key->title }}
                        </a>
                        @if (isset($learn_status[$key->id]) && $learn_status[$key->id] == Auth::user()->id)
                        <span class="badge badge-primary badge-pill"><i class="fas fa-check"></i></span>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-9 p-lg-5 p-3 shadow-sm border rounded-lg">
                <div class="my-5">
                    {!! $detail->content !!}
                </div>
                <div class="border-top pt-3">
                    <div class="row">
                        @section('prev')
                        <div class="col-12 col-md-6">
                            <a class="btn btn-secondary text-indigo d-block d-md-inline-block mb-2 mb-md-0" href="{{ route('lecture.show', [$modul->slug, ($detail->urutan - 1)]) }}">
                                <i class="fas fa-arrow-alt-circle-left mr-2"></i>Materi sebelumnya
                            </a>
                        </div>
                        @endsection

                        @section('next')
                        <div class="col-12 col-md-6 text-md-right">
                            <a class="btn btn-secondary text-indigo d-block d-md-inline-block" href="{{ route('lecture.show', [$modul->slug, ($detail->urutan + 1)]) }}">
                                Materi berikutnya<i class="fas fa-arrow-alt-circle-right ml-2"></i>
                            </a>
                        </div>
                        @endsection

                        @if($detail->urutan < 2 && $lecture->count() > 1)
                            <div class="col-12 col-md-6"></div>
                            @yield('next')
                            @elseif($detail->urutan == $lecture->count() && $lecture->count() > 1)
                            @yield('prev')
                            <div class="col-12 col-md-6 text-md-right"></div>
                            @elseif($detail->urutan > 1 && $detail->urutan < $lecture->count())
                                @yield('prev')
                                @yield('next')
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection