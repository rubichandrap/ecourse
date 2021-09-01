@extends('layouts.app')

@section('content')
@include('template.showModulHeader')
<section class="section-divider">
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
        @endif
        <ul id="modul-tab" class="nav nav-tabs" data-parse="{{ $modul->slug }}">
            <li class="nav-item">
                <a id="desc-link" data-content="desc" class="nav-link {{ request()->is('modul/'.$modul->slug) || request()->is('modul/'.$modul->slug.'/desc') ? 'active disabled' : '' }}" href="#">Deskripsi</a>
            </li>
            <li class="nav-item">
                <a id="lecture-link" data-content="lecture" class="nav-link {{ request()->is('modul/'.$modul->slug.'/lecture') ? 'active disabled' : '' }}" href="#">Materi</a>
            </li>
            <li class="nav-item">
                <a id="faq-link" data-content="faq" class="nav-link {{ request()->is('modul/'.$modul->slug.'/faq') ? 'active disabled' : '' }}" href="#">FAQ</a>
            </li>
        </ul>
        <div id="ajax-modul" class="pt-4 pb-4">
            <!-- ajax method -->
            @if(request()->is('modul/'.$modul->slug) || request()->is('modul/'.$modul->slug.'/desc'))
            <div class="row">
                <div class="col-12">
                    {!! $modul->desc !!}
                </div>
            </div>
            @elseif(request()->is('modul/'.$modul->slug.'/lecture'))
            @include('func.ajaxModulMateri')
            @elseif(request()->is('modul/'.$modul->slug.'/faq'))
            @include('func.ajaxModulFaq')
            @endif
        </div>
    </div>
</section>
@endsection