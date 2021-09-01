<a class="d-lg-none post-action-icon" href="#" role="button" id="dropdownFeatures" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-ellipsis-h"></i>
    </a>
    <div class="d-lg-none dropdown-menu dropdown-menu-right dropdown-menu-arrow" aria-labelledby="dropdownFeatures">
        <a class="dropdown-item {{ request()->is('kelas/'.$kelas->id.'/session/'.$session->session_of) ? 'active' : '' }}" href="{{ route('session.show', [$kelas->id, $session->session_of]) }}">
            Overview
        </a>
        <a class="dropdown-item {{ request()->is('kelas/'.$kelas->id.'/session/'.$session->session_of.'/absent') ? 'active' : '' }}" href="{{route('absent.index', [$kelas->id, $session->session_of])}}">Absen</a>
        <a class="dropdown-item {{ (request()->is('modul')) ? 'active' : '' }}" href="{{ url('/modul')}}">Tugas</a>

        @if($all_session->count() > 1)
        <div class="dropdown-divider"></div>
        @endif

        <div class="row">
            @if($session->session_of < 2 && $all_session->count() > 1)
                <div class="col-12">
                    <a class="dropdown-item" href="{{ route('session.show', [$kelas->id, intval($session->session_of + 1)]) }}">Sesi selanjutnya</a>
                </div>
                @elseif($session->session_of == $all_session->count() && $all_session->count() > 1)
                <div class="col-12">
                    <a class="dropdown-item" href="{{ route('session.show', [$kelas->id, intval($session->session_of - 1)]) }}">Sesi sebelumnya</a>
                </div>
                @elseif($session->session_of > 1 && $session->session_of < $all_session->count())
                    <div class="col-12">
                        <a class="dropdown-item" href="{{ route('session.show', [$kelas->id, intval($session->session_of - 1)]) }}">Sesi sebelumnya</a>
                    </div>
                    <div class="col-12">
                        <a class="dropdown-item" href="{{ route('session.show', [$kelas->id, intval($session->session_of + 1)]) }}">Sesi selanjutnya</a>
                    </div>
                    @endif
        </div>
    </div>