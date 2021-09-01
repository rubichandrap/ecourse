<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <title>eCourse - Welcome</title>

        @include('template.head')

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        
        <style>
            html, body {
            color: #fff;
            background: #8509a1;
            font-family: 'Nunito', sans-serif;
            font-weight: 400;
            margin: 0;
            }

        </style>
    </head>
    <body>
        <div id="app" class="application">
            <div class="full-height">
                <nav id="kustom-nav" class="navbar">
                    <div class="container">
                        <div class="ml-auto">
                            @include('template.mobileMenu')
                        </div>                        
                    </div>

                </nav>

                <div class="center-menu">
                    <div class="content">
                        <div class="title m-bm-vsm">
                            eCOURSE
                            <span class="position-absolute btn-danger shadow-none right-0 top-0" style="font-size: 1rem; padding: 1px 4.5px;">
                                BETA
                            </span>
                        </div>
                    </div>

                    @if (Route::has('login'))
                    <div class="links">
                        @auth
                        <a class="shadow" href="{{ url('/home') }}">Beranda</a>
                        @else
                        <a class="shadow" href="{{ route('login') }}">Login</a>
                            @if (Route::has('register'))
                            <a class="shadow" href="{{ route('register') }}">Register</a>
                            @endif
                        @endauth
                    </div>
                    @endif
                    
                </div>
            </div>
        </div>
        @include('template.script')
    </body>

</html>
