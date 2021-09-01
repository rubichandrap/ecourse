<div class="row">
    <div class="col-12">
        <h2>Daftar Materi</h2>
        <div class="form-inline my-4">
            <div id="search-form" class="js-live-search form-inline mb-0 mr-2 w-100">
                <input class="form-control mr-2 w-75" type="text" placeholder="Cari Materi" name="search_input_materi" value="" />
                <div class="p-2">
                    <i class="fas fa-search"></i>
                </div>
            </div>
        </div>
        <div class="card border-0">
            <table class="table table-responsive-sm table-hover js-live-search-table">
                <thead>
                    <tr>
                        <th scope="col" style="font-size: .8rem !important;">Materi</th>
                        <th scope="col" style="font-size: .8rem !important;">Status</th>
                        @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('dosen'))
                        <th scope="col" style="font-size: .8rem !important;">Publish</th>
                        <th scope="col" style="font-size: .8rem !important;">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($list as $key)
                    <tr>
                        <th scope="row" style="font-size: 1rem !important;">
                            <a href="{{ route('lecture.show', [$modul->slug, $key->urutan]) }}">
                                {{ $key->title }}
                            </a>
                        </th>
                        <td scope="row" style="font-size: 1rem !important;">
                            @if (isset($learn_status[$key->id]) && $learn_status[$key->id] == Auth::user()->id)
                            <i class="fas fa-check mr-2"></i>Selesai
                            @endif
                        </td>
                        @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('dosen'))
                        <td scope="row">
                            <ul>
                                <li>
                                    <form action="{{ route('lecture.status') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $key->id }}">
                                        <input type="hidden" name="status" value="1">
                                        <button type="submit" class="btn btn-sm btn-default" {{ $key->status == '1' ? 'disabled' : '' }}><i class="fa fa-check" aria-hidden="true"></i></button>
                                    </form>
                                </li>
                                <li>
                                    <form action="{{ route('lecture.status') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $key->id }}">
                                        <input type="hidden" name="status" value="0">
                                        <button type="submit" class="btn btn-sm btn-default" {{ $key->status == '0' ? 'disabled' : '' }}><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                    </form>
                                </li>
                            </ul>
                        </td>
                        <td scope="row">
                            <ul>
                                <li class="p-0">
                                    <a class="btn btn-sm btn-info" href="{{ route('lecture.show', [$modul->slug, $key->urutan]) }}">Show</a>
                                </li>
                                <li class="p-0">
                                    <a class="btn btn-sm btn-success" href="{{route('lecture.edit', [$modul->slug, $key->urutan])}}">Edit</a>
                                </li>
                                <li class="p-0">
                                    <form method="POST" action="{{route('lecture.destroy', [$modul->slug, $key->urutan])}}">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE" />
                                        <button class="btn btn-sm btn-danger del-btn" type="button" data-toggle="modal" data-target="#modal-del{{$key->urutan}}">Delete</button>
                                        <div id="modal-del{{$key->urutan}}" class="modal fade" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Hapus Data</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="text-wrap">Anda yakin ingin menghapus Materi pada {{ $modul->slug }} dengan urut : {{$key->urutan}} ?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Ya</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </li>
                            </ul>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('dosen'))
                    @foreach($unpublish as $key)
                    <tr>
                        <th scope="row" style="font-size: 1rem !important;"><a class="text-muted" href="{{ route('lecture.edit', [$modul->slug, $key->urutan]) }}">{{ $key->title }}</a></th>
                        <td scope="row" style="font-size: 1rem !important;">
                            @if (isset($learn_status[$key->id]) && $learn_status[$key->id] == Auth::user()->id)
                            <i class="fas fa-check mr-2"></i>Selesai
                            @endif
                        </td>
                        <td scope="row">
                            <ul>
                                <li>
                                    <form action="{{ route('lecture.status', $modul->slug) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input class="mb-1" type="hidden" name="id" value="{{ $key->id }}">
                                        <input type="hidden" name="status" value="1">
                                        <button type="submit" class="btn btn-sm btn-default" {{ $key->status == '1' ? 'disabled' : '' }}><i class="fa fa-check" aria-hidden="true"></i></button>
                                    </form>
                                </li>
                                <li>
                                    <form action="{{ route('lecture.status', $modul->slug) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $key->id }}">
                                        <input type="hidden" name="status" value="0">
                                        <button type="submit" class="btn btn-sm btn-default" {{ $key->status == '0' ? 'disabled' : '' }}><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                    </form>
                                </li>
                            </ul>
                        </td>
                        <td scope="row">
                            <ul>
                                <li class="p-0">
                                    <a class="btn btn-sm btn-info" href="{{ route('lecture.edit', [$modul->slug, $key->urutan]) }}">Show</a>
                                </li>
                                <li class="p-0">
                                    <a class="btn btn-sm btn-success" href="{{route('lecture.edit', [$modul->slug, $key->urutan])}}">Edit</a>
                                </li>
                                <li class="p-0">
                                    <form method="POST" action="{{route('lecture.destroy', [$modul->slug, $key->urutan])}}">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE" />
                                        <button class="btn btn-sm btn-danger del-btn" type="button" data-toggle="modal" data-target="#modal-del{{$key->urutan}}">Delete</button>
                                        <div id="modal-del{{$key->urutan}}" class="modal fade" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Hapus Data</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="text-wrap">Anda yakin ingin menghapus Materi pada {{ $modul->slug }} dengan urut : {{$key->urutan}} ?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Ya</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('dosen'))
                    <tr id="add-link">
                        <th scope="row" colspan="4" style="font-size: 1rem !important;">
                            <a href="{{ route('lecture.create', $modul->slug) }}"><i class="fas fa-plus mr-2"></i>Tambah Materi</a>
                        </th>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>