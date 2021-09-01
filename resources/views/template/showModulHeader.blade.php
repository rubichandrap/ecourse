<header>
    <div class="container-fluid p-0 bg-gray-dark">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0 bg-transparent">
                    <li class="breadcrumb-item"><a class="text-white" href="{{ route('home') }}">Beranda</a></li>
                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('dosen'))
                    <li class="breadcrumb-item"><a class="text-white" href="{{ route('modul.index') }}">Modul</a></li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ $modul->title }}</li>
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
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="card bg-transparent border-0">
                        <div class="row">
                            <div class="col-md-6 col-lg-5 mb-3 mb-md-0">
                                <img class="card-img" src="{{ Storage::url($modul->image) }}">
                                @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('dosen'))
                                <div class="position-absolute top-0 left-3">
                                    <ul class="pt-2">
                                        <li class="p-0">
                                            <a class="btn btn-sm btn-primary" href="javascript:history.back()" title="Back">
                                                <i class="fas fa-backspace"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="position-absolute top-0 right-3">
                                    <ul class="pt-2">
                                        <li class="p-0">
                                            <form action="{{ route('modul.status') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input class="mb-1" type="hidden" name="id" value="{{ $modul->id }}">
                                                <input type="hidden" name="status" value="1">
                                                <button type="submit" class="btn btn-sm btn-default" {{ $modul->status == '1' ? 'disabled' : '' }}><i class="fa fa-check" aria-hidden="true" title="Publish"></i></button>
                                            </form>
                                        </li>
                                        <li class="p-0">
                                            <form action="{{ route('modul.status') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $modul->id }}">
                                                <input type="hidden" name="status" value="0">
                                                <button type="submit" class="btn btn-sm btn-default" {{ $modul->status == '0' ? 'disabled' : '' }}><i class="fa fa-eye-slash" aria-hidden="true" title="Hidden"></i></button>
                                            </form>
                                        </li>
                                        <li class="p-0">
                                            <a class="btn btn-sm btn-success" href="{{route('modul.edit', $modul->slug)}}" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-6 col-lg-7">
                                <h1 class="text-white-custom font-weight-bold mb-1">{{ $modul->title }}</h1>
                                <div class="row">
                                    <div class="col-6">
                                        <span class="text-white-custom">Level : {{ $modul->level }}</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-white-custom">Platform : {{ $modul->platform }}</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-white-custom">Materi : {{ $lecture }}</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-white-custom">Penyusun : rubichandrap</span>
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