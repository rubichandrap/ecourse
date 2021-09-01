@extends('layouts.app')

@section('content')
@include('template.showKelasHeader')
<section class="section-divider pt-9">
    <div class="container">
        @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul class="ml-0">
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
        <ul id="kelas-tab" class="nav nav-tabs" data-parse="{{ $kelas->id }}">
            <li class="nav-item">
                <a id="desc-link" data-content="desc" class="nav-link {{ request()->is('kelas/' . $kelas->id) || request()->is('kelas/' . $kelas->id . '/desc') ? 'active' : '' }}" href="#">Deskripsi</a>
            </li>
            <li class="nav-item">
            <a id="session-link" data-content="session" class="nav-link {{ request()->is('kelas/' .$kelas->id. '/session') ? 'active' : '' }}" href="#">Sesi</a>
            </li>
            <li class="nav-item">
                <a id="peserta-link" data-content="peserta" class="nav-link {{ request()->is('kelas/' .$kelas->id. '/peserta') ? 'active' : '' }}" href="#">Peserta</a>
            </li>
            <li class="nav-item">
                <a id="faq-link" data-content="faq" class="nav-link" href="#">FAQ</a>
            </li>
        </ul>
        <div id="ajax-kelas" class="pt-4 pb-4">
           <!-- ajax method -->
           @if(request()->is('kelas/' . $kelas->id) || request()->is('kelas/' . $kelas->id . '/desc'))
           <div class="row">
               <div class="col-12">
                   {!! $kelas->desc !!}
               </div>
           </div>
           @elseif(request()->is('kelas/' .$kelas->id. '/session'))
           @include('func.ajaxKelasSession')
           @elseif(request()->is('kelas/' .$kelas->id. '/peserta'))
           @include('func.ajaxKelasPeserta')
           @endif
        </div>
    </div>
</section>
@endsection