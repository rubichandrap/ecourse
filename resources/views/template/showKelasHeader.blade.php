<header>
    <div class="container-fluid p-0 bg-gray-dark">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0 bg-transparent">
                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('dosen'))
                    <li class="breadcrumb-item"><a class="text-white" href="{{ route('kelas.index') }}">Kelas</a></li>
                    @else
                    <!-- different view from what admin and dosen get -->
                    <li class="breadcrumb-item"><a class="text-white" href="{{ route('kelas.index') }}">Kelas</a></li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ $kelas->title }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="jumbotron jumbotron-fluid jumbotron-custom bg-dark text-white m-0 no-select position-relative">
        <div class="bg-icons">
        </div>
    </div>
    <div class="jumbotron-content mt--9">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card bg-transparent border-0">
                        <div class="row">
                            <div class="col-12 col-md-8 col-lg-6">
                                <h1 class="text-white font-weight-bold mb-1">{{ $kelas->title }}</h1>
                                <div class="row">
                                    <div class="col-6">
                                        <span class="text-white">Dosen : {{ $kelas->user->name }}</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-white">Sesi : {{ count($session) }} dari {{ $kelas->sessions }} Pertemuan</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-white">Partisipan : {{ $kelas->user_joined_count }} Peserta</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>