<ul class="nav">
    <li class="nav-item">
        <a class="nav-link {{ (request()->is('home')) ? 'active' : '' }}" href="{{ url('/home')}}">Beranda</a>
    </li>
    @auth
    <li class="nav-item">
        <div class="dropdown">
            @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('dosen'))
            <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownActivities" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Activities
            </a>
            @else
            <a class="nav-link {{ (request()->is('kelas')) ? 'active' : '' }}" href="{{ url('/kelas') }}">
                Kelas
            </a>
            @endif
            @if(Auth::user()->hasRole('admin'))
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" aria-labelledby="dropdownActivities">
                <a class="dropdown-item {{ (request()->is('mahasiswa')) ? 'active' : '' }}" href="{{ url('/mahasiswa')}}">Mahasiswa</a>
                <a class="dropdown-item {{ (request()->is('dosen')) ? 'active' : '' }}" href="{{ url('/dosen')}}">Dosen</a>
                <a class="dropdown-item {{ (request()->is('kelas')) ? 'active' : '' }}" href="{{ url('/kelas')}}">Kelas</a>
                <a class="dropdown-item {{ (request()->is('modul')) ? 'active' : '' }}" href="{{ url('/modul')}}">Modul</a>
            </div>
            @elseif(Auth::user()->hasRole('dosen'))
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" aria-labelledby="dropdownActivities">
                <a class="dropdown-item {{ (request()->is('kelas')) ? 'active' : '' }}" href="{{ url('/kelas')}}">Kelas</a>
                <a class="dropdown-item {{ (request()->is('modul')) ? 'active' : '' }}" href="{{ url('/modul')}}">Modul</a>
            </div>
            @endif
        </div>
    </li>
    @endauth
    <li class="nav-item">
        <a class="nav-link" href="https://www.stmikmj.ac.id/" target="_blank">Kampus</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ (request()->is('tentang')) ? 'active' : '' }}" href="{{ url('/tentang')}}">Tentang</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ (request()->is('kontak')) ? 'active' : '' }}" href="{{ url('/kontak') }}">Kontak</a>
    </li>
</ul>