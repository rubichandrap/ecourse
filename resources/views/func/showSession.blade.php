@extends('layouts.app')

@section('content')
<header>
    @php
        $overview_link = 'kelas/'.$kelas->id.'/session/'.$session->session_of;  
        $absent_link = 'kelas/'.$kelas->id.'/session/'.$session->session_of.'/absent';
        $tugas_link = 'kelas/'.$kelas->id.'/session/'.$session->session_of.'/tugas'; 
    @endphp
    <div class="container-fluid p-0 bg-gray-dark">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0 bg-transparent">
                    <li class="breadcrumb-item"><a class="text-white" href="{{ route('kelas.index') }}">Kelas</a></li>
                    <li class="breadcrumb-item">
                        <a class="text-white" href="{{ route('kelas.show', $kelas->id) }}">
                            {{$kelas->title}}</a>
                    </li>
                    <li class="breadcrumb-item {{ request()->is($overview_link) ? 'active' : '' }}" 
                        aria-current="{{ request()->is($overview_link) ? 'page' : '' }}">
                        @if(request()->is($overview_link))
                            {{ $session->title }}
                        @else
                        <a class="text-white" href="{{ route('session.show', [$kelas->id, $session->session_of]) }}">{{ $session->title }}</a>
                        @endif
                    </li>
                    @if(request()->is($absent_link))
                    <li class="breadcrumb-item {{ request()->is($absent_link) ? 'active' : '' }}" 
                            aria-current="{{ request()->is($absent_link) ? 'page' : '' }}">
                            @if(request()->is($absent_link))
                                Absen
                            @else
                            <a class="text-white" href="{{ route('absent.index', [$kelas->id, $session->session_of]) }}">Absen</a>
                            @endif
                    </li>
                    @endif
                    @if(request()->is($tugas_link))
                    <li class="breadcrumb-item {{ request()->is($tugas_link) ? 'active' : '' }}" 
                            aria-current="{{ request()->is($tugas_link) ? 'page' : '' }}">
                            @if(request()->is($tugas_link))
                                Tugas
                            @else
                            <a class="text-white" href="{{ route('absent.index', [$kelas->id, $session->session_of]) }}">Tugas</a>
                            @endif
                    </li>
                    @endif
                </ol>
            </nav>
        </div>
    </div>
</header>
<section class="section-divider">
    <div class="container">
        @if(\Session::has('success'))
        <div class="alert alert-success">
            <p class="m-0">{{\Session::get('success')}}</p>
        </div>
        @elseif(\Session::has('failure'))
        <div class="alert alert-danger">
            <p class="m-0">{{\Session::get('failure')}}</p>
        </div>
        @endif
        <a class="d-inline-block pb-2" href="javascript:history.back()"><i class="fa fa-arrow-left mr-2"></i>Kembali</a>
        <div class="row">
            <div class="d-none d-lg-block col-12 col-lg-3 pb-5">
                <div class="col-12 p-0">
                    <h2 class="mb-4">Akses Fitur</h2>
                    <ul class="list-group">
                        <li class="list-group-item {{ request()->is('kelas/'.$kelas->id.'/session/'.$session->session_of) ? 'active' : '' }}">
                            <a class="{{ request()->is('kelas/'.$kelas->id.'/session/'.$session->session_of) ? 'text-white' : '' }}" href="{{ route('session.show', [$kelas->id, $session->session_of]) }}">
                                Overview
                            </a>
                        </li>
                        <li class="list-group-item {{ request()->is('kelas/'.$kelas->id.'/session/'.$session->session_of.'/absent') ? 'active' : '' }}">
                            <a class="{{ request()->is('kelas/'.$kelas->id.'/session/'.$session->session_of.'/absent') ? 'text-white' : '' }}" href="{{route('absent.index', [$kelas->id, $session->session_of])}}">Absen</a>
                        </li>
                        <li class="list-group-item {{ request()->is('kelas/'.$kelas->id.'/session/'.$session->session_of.'/tugas') ? 'active' : '' }}">
                        <a class="{{ request()->is('kelas/'.$kelas->id.'/session/'.$session->session_of.'/tugas') ? 'text-white' : '' }}" href="{{ route('tugas.index', [$kelas->id, $session->session_of]) }}">Tugas</a>
                        </li>
                    </ul>
                </div>
                <div class="col-12 p-0">
                    <h2 class="mt-4">Sesi Lainnya</h2>
                    <div class="form-inline my-4">
                        <div id="search-form" class="js-live-search-session form-inline mb-0 mr-2 w-100">
                            <input class="form-control mr-2 w-75" type="text" placeholder="Cari Sesi" name="search_input_session" />
                            <div class="p-2">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>
                    <ul class="js-live-search-list list-group">
                        @foreach($all_session as $key)
                        <li class="list-group-item {{ request()->is('kelas/'.$kelas->id.'/session/'.$key->session_of.'*') ? 'active' : '' }}">
                            <a class="{{ request()->is('kelas/'.$kelas->id.'/session/'.$key->session_of.'*') ? 'text-white' : '' }}" href="{{route('session.show', [$kelas->id, $key->session_of])}}">
                                {{ $key->title }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-12 col-lg-9">
                @if(request()->is('kelas/'.$kelas->id.'/session/'.$session->session_of))
                    @include('func.showSessionOverview')
                @elseif(request()->is('kelas/'.$kelas->id.'/session/'.$session->session_of.'/absent'))
                    @include('func.showSessionAbsent')
                @elseif(request()->is('kelas/'.$kelas->id.'/session/'.$session->session_of.'/tugas'))
                    @include('func.showSessionTugas')
                @endif
            </div>
        </div>
    </div>
</section>
@endsection