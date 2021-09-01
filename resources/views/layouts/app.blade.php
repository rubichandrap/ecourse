<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>eCourse - {{ $title ?? '' }}</title>

    @include('template.head')

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"> --}}

</head>

<body>
    <div id="app" class="application">
        <nav id="kustom-nav" class="navbar navbar-dark shadow-sm app-nav fixed-top">
            <div class="container">
                @guest
                <div class="horizontal-menus mr-auto">
                    <a style="font-family: 'Nunito-ExtraBold';" class="navbar-brand no-select position-relative" href="{{ url('/') }}">
                        <i class="fas fa-graduation-cap"></i>eCOURSE
                        <span class="position-absolute btn-danger shadow-none right--2 top--2" style="font-size: .45rem; padding: 1.5px 3.5px;">
                            BETA
                        </span>
                    </a>
                    <div class="d-none d-lg-flex">
                        @include('template.horizontalMenu')
                    </div>
                </div>
                <div class="horizontal-menus">
                    <div class="d-none d-lg-flex">
                        <ul class="nav d-none d-lg-flex">
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('login')) ? 'active' : '' }}" href="{{ url('/login')}}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('register')) ? 'active' : '' }}" href="{{ url('/register')}}">Register</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('password/reset')) ? 'active' : '' }}" href="{{ route('password.request') }}">Lupa Password</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="d-block d-lg-none">
                    @include('template.mobileMenu')
                </div>
                @else
                <div class="horizontal-menus mr-auto">
                    <a style="font-family: 'Nunito-ExtraBold';" class="navbar-brand no-select position-relative" href="{{ url('/') }}">
                        <i class="fas fa-graduation-cap"></i>eCOURSE
                        <span class="position-absolute btn-danger shadow-none right--2 top--2" style="font-size: .45rem; padding: 1.5px 3.5px;">
                            BETA
                        </span>
                    </a>
                    <div class="d-none d-lg-flex">
                        @include('template.horizontalMenu')
                    </div>
                </div>
                <form id="search-form" class="form-inline mb-0 mr-2" method="GET" action="{{ route('pencarian') }}">
                    <input class="form-control srch-input" type="text" placeholder="Mau Belajar Apa?" name="search_input" value="{{old('search_input')}}" />
                    <button class="btn srch-button" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <div class="profile-menu d-none d-lg-flex">
                    @include('template.profileMenu')
                </div>
                <div class="d-block d-lg-none">
                    @include('template.mobileMenu')
                </div>
                @endguest
            </div>
            @include('template.gotop')
        </nav>

        <main class="px-0 pb-0 p-navbar">
            @yield('content')
        </main>
        @include('template.footer')
    </div>
    @include('template.script')
</body>

</html>