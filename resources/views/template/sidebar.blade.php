<div id="sidebar" class="sidebar no-select">
    <div class="close-icon">
        <span></span>
        <span></span>
    </div>
    <!-- SECTIONS -->
    <!-- Lists -->
    @section('guestList')
    <li><a class="{{ (request()->is('home')) ? 'active' : '' }}" href="{{ url('/home')}}"><i class="fas fa-home mr-2"></i>Beranda</a>
    </li>
    @endsection

    @section('adminList')
    <li><a class="{{ (request()->is('home')) ? 'active' : '' }}" href="{{ url('/home')}}"><i class="fas fa-home mr-2"></i>Beranda</a>
    </li>
    <li><a class="{{ (request()->is('mahasiswa')) ? 'active' : '' }}" href="{{ url('/mahasiswa')}}"><i class="fas fa-users mr-2"></i>Mahasiswa</a>
    </li>
    <li><a class="{{ (request()->is('dosen')) ? 'active' : '' }}" href="{{ url('/dosen')}}"><i class="fas fa-user-tie mr-2"></i>Dosen</a>
    </li>
    <li><a class="{{ (request()->is('kelas')) ? 'active' : '' }}" href="{{ url('/kelas')}}"><i class="fas fa-school mr-2"></i>Kelas</a>
    </li>
    <li><a class="{{ (request()->is('modul')) ? 'active' : '' }}" href="{{ url('/modul')}}"><i class="fas fa-book-open mr-2"></i>Modul</a>
    </li>
    {{-- <li><a class="{{ (request()->is('lecture')) ? 'active' : '' }}" href="{{ url('/lecture')}}"><i class="fas fa-bookmark mr-2"></i>Materi</a>
    </li> --}}
    @endsection

    @section('dosenList')
    <li><a class="{{ (request()->is('home')) ? 'active' : '' }}" href="{{ url('/home')}}"><i class="fas fa-home mr-2"></i>Beranda</a>
    </li>
    <li><a class="{{ (request()->is('kelas')) ? 'active' : '' }}" href="{{ url('/kelas')}}"><i class="fas fa-school mr-2"></i>Kelas</a>
    </li>
    <li><a class="{{ (request()->is('modul')) ? 'active' : '' }}" href="{{ url('/modul')}}"><i class="fas fa-book-open mr-2"></i>Modul</a>
    </li>
    {{-- <li><a class="{{ (request()->is('lecture')) ? 'active' : '' }}" href="{{ url('/lecture')}}"><i class="fas fa-bookmark mr-2"></i>Materi</a>
    </li> --}}
    @endsection

    @section('mahasiswaList')
    <li><a class="{{ (request()->is('home')) ? 'active' : '' }}" href="{{ url('/home')}}"><i class="fas fa-home mr-2"></i>Beranda</a>
    </li>
    <li><a class="{{ (request()->is('kelas')) ? 'active' : '' }}" href="{{ url('/kelas')}}"><i class="fas fa-school mr-2"></i>Kelas</a>
    </li>
    @endsection

    @section('extendedList')
    <li><a class="" href="https://www.stmikmj.ac.id/" target="_blank"><i class="fa fa-university mr-2"></i>Kampus</a>
    </li>
    <li><a class="{{ (request()->is('tentang')) ? 'active' : '' }}" href="{{ url('/tentang')}}"><i class="fas fa-user mr-2"></i>Tentang</a>
    </li>
<li><a class="{{ (request()->is('kontak')) ? 'active' : '' }}" href="{{ url('/kontak') }}"><i class="fa fa-phone mr-2"></i>Kontak</a>
    </li>
    @endsection

    <!-- Auth List -->
    @section('userAuth')
    <li><a class="{{ (request()->is('login')) ? 'active' : '' }}" href="{{ url('/login') }}"><i class="fas fa-sign-in-alt mr-2"></i>Login</a>
    </li>
    @if (Route::has('register'))
    <li><a class="{{ (request()->is('register')) ? 'active' : '' }}" href="{{ url('/register') }}"><i class="fas fa-clipboard mr-2"></i>Register</a>
    </li>
    @endif
    @endsection

    <!-- Forgot Password List -->
    @section('forgotPassword')
    <li><a class="{{ (request()->is('password/reset')) ? 'active' : '' }}" href="{{ route('password.request') }}"><i class="fas fa-lock mr-2"></i>Lupa Password</a></li>
        @endsection
        <!-- END SECTIONS -->
        <!-- START! -->
        @if(request()->is('/') && Auth::guest())
        <div class="menu">
            <ul>
                @yield('guestList')
            </ul>
        </div>
        <div class="menu">
            <ul>
                @yield('extendedList')
            </ul>
        </div>
        <div class="menu">
            <ul>
                @yield('forgotPassword')
            </ul>
        </div>
        @else
        @guest
        <div class="menu">
            <ul>
                @yield('guestList')
            </ul>
        </div>
        <div class="menu">
            <ul>
                @yield('extendedList')
            </ul>
        </div>
        <div class="menu">
            <ul>
                @yield('userAuth')
                @yield('forgotPassword')
            </ul>
        </div>
        @else
        @if(Auth::user()->hasRole('admin'))
        <div class="menu">
            <ul>
                <li><a class="{{ (request()->is('profile')) ? 'active' : '' }}" href="{{url('/profile')}}"><i class="fas fa-user-cog mr-2"></i>
                        {{ Auth::user()->username }}
                    </a>
                </li>
            </ul>
        </div>
        <div class="menu">
            <ul>
                @yield('adminList')
            </ul>
        </div>
        @elseif(Auth::user()->hasRole('dosen'))
        <div class="menu">
            <ul>
                <li><a class="{{ (request()->is('profile')) ? 'active' : '' }}" href="{{url('/profile')}}"><i class="fas fa-user-tie mr-2"></i>
                        {{ Auth::user()->username }}
                    </a>
                </li>
            </ul>
        </div>
        <div class="menu">
            <ul>
                @yield('dosenList')
            </ul>
        </div>
        @else
        <div class="menu">
            <ul>
                <li><a class="{{ (request()->is('profile')) ? 'active' : '' }}" href="{{url('/profile')}}"><i class="fas fa-user-graduate mr-2"></i>
                        {{ Auth::user()->username }}
                    </a>
                </li>
            </ul>
        </div>
        <div class="menu">
            <ul>
                @yield('mahasiswaList')
            </ul>
        </div>
        @endif
        <div class="menu">
            <ul>
                @yield('extendedList')
            </ul>
        </div>
        <div class="menu">
            <ul>
                <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i>
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
        @endguest
        @endif
</div>