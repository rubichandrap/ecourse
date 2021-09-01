@extends('layouts.app')

@section('content')
<header>
    <div class="jumbotron jumbotron-fluid jumbotron-custom bg-dark text-white m-0 no-select position-relative">
        <div class="bg-icons">
        </div>
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1 class="display-3 mb-0 text-white">Kamu lagi di kelas,</h1>
                    <p style="font-size: 1.2rem;">Tempat kamu cari ilmu sama dosen dan temen-temen kamu!</p>
                </div>
            </div>
        </div>
    </div>
</header>
<section class="section-divider">
    <div class="container">
        @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li class="list-style-none">{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if(\Session::has('success'))
        <div class="alert alert-success">
            <p class="m-0">{{\Session::get('success')}}</p>
        </div>
        @elseif(\Session::has('failure'))
        <div class="alert alert-danger">
            <p class="m-0">{{\Session::get('failure')}}</p>
        </div>
        @endif
        <ul id="kelas-mahasiswa-tab" class="nav nav-tabs">
            <li class="nav-item">
                <a id="list-link" data-content="list" class="nav-link {{ request()->is('kelas') || request()->is('kelas/list') ? 'active' : '' }}" href="#">Kelas Kamu</a>
            </li>
            <li class="nav-item">
                <a id="join-link" data-content="join" class="nav-link {{ request()->is('kelas/join') ? 'active' : '' }}" href="#">Gabung Kelas</a>
            </li>
        </ul>
        <div id="ajax-kelas-mahasiswa" class="pt-4 pb-4">
            <!-- ajax method -->
            @if(request()->is('kelas') || request()->is('kelas/list'))
            <div class="row">
                <div class="col-12">
                    <h2>Daftar Kelas</h2>
                    <div class="form-inline my-4">
                        <div id="search-form" class="js-live-search form-inline mb-0 mr-2 w-100">
                            <input class="form-control mr-2 w-75" type="text" placeholder="Cari Kelas" name="search_input_materi" value="" />
                            <div class="p-2">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card border-0">
                        <table class="table table-responsive-sm table-hover js-live-search-table">
                            <thead>
                                <tr>
                                    <th scope="col" style="font-size: .8rem !important;">Title</th>
                                    <th scope="col" style="font-size: .8rem !important;">Dosen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kelas as $key)
                                <tr>
                                    <th scope="row" style="font-size: 1rem !important;">
                                        <a href="{{ route('kelas.show', $key->id) }}">
                                            {{ $key->title }}
                                        </a>
                                    </th>
                                    <td scope="row" style="font-size: 1rem !important;">
                                        {{ $key->user->name }}<i class="fa fa-star ml-2 text-yellow"></i>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @elseif(request()->is('kelas/join'))
            @include('func.ajaxKelasJoin')
            @endif
        </div>
    </div>
</section>
@endsection