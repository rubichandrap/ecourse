<div class="row">
    <div class="col-12">
        <h2>Daftar Sesi</h2>
        <div class="form-inline my-4">
            <div id="search-form" class="js-live-search form-inline mb-0 mr-2 w-100">
                <input class="form-control mr-2 w-75" type="text" placeholder="Cari Sesi" name="search_input_materi" value="" />
                <div class="p-2">
                    <i class="fas fa-search"></i>
                </div>
            </div>
        </div>
        <div class="card border-0">
            <table class="table table-responsive-sm table-hover js-live-search-table">
                <thead>
                    <tr>
                        <th scope="col" style="font-size: .8rem !important;">Title</th>
                        <th scope="col" style="font-size: .8rem !important;">Status</th>
                        @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('dosen'))
                        <th scope="col" style="font-size: .8rem !important;">Open</th>
                        <th scope="col" style="font-size: .8rem !important;">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($session as $key)
                    <tr>
                        <th scope="row" style="font-size: 1rem !important;">
                            <a href="{{ route('session.show', [$key->kelas_id, $key->session_of]) }}">
                                {{ $key->title }}
                            </a>
                        </th>
                        <td scope="row" style="font-size: 1rem !important;">
                            @if($key->status == '0')
                            <i class="fa fa-times mr-2"></i>Closed
                            @else
                            <i class="fa fa-check mr-2"></i>Active
                            @endif
                        </td>
                        @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('dosen'))
                        <td scope="row">
                            <ul>
                                <li>
                                    <form action="{{ route('session.status') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $key->id }}">
                                        <input type="hidden" name="status" value="1">
                                        <button type="submit" class="btn btn-sm btn-default" {{ $key->status == '1' ? 'disabled' : '' }}><i class="fa fa-check" aria-hidden="true"></i></button>
                                    </form>
                                </li>
                                <li>
                                    <form action="{{ route('session.status') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $key->id }}">
                                        <input type="hidden" name="status" value="0">
                                        <button type="submit" class="btn btn-sm btn-default" {{ $key->status == '0' ? 'disabled' : '' }}><i class="fa fa-times" aria-hidden="true" style="font-size: .85rem;"></i></button>
                                    </form>
                                </li>
                            </ul>
                        </td>
                        <td scope="row">
                            <ul>
                                <li class="p-0">
                                    <a class="btn btn-sm btn-info" href="{{ route('session.show', [$key->kelas_id, $key->session_of]) }}">Show</a>
                                </li>
                                <li class="p-0">
                                    <a class="btn btn-sm btn-success" href="{{ route('session.edit', [$key->kelas_id, $key->session_of]) }}">Edit</a>
                                </li>
                                <li class="p-0">
                                    <form method="POST" action="{{ route('session.destroy', [$key->kelas_id, $key->session_of]) }}">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE" />
                                        <button class="btn btn-sm btn-danger del-btn" type="button" data-toggle="modal" data-target="#modal-del{{$key->session_of}}">Delete</button>
                                        <div id="modal-del{{$key->session_of}}" class="modal fade" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Hapus Data</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="text-wrap">Anda yakin ingin menghapus Sesi pada {{ $kelas->title }} dengan urut : {{$key->session_of}} ?</p>
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
                    @if((Auth::user()->hasRole('admin') || Auth::user()->hasRole('dosen')) && count($session) < $kelas->sessions)
                    <tr id="add-link">
                        <th scope="row" colspan="4" style="font-size: 1rem !important;">
                            <a href="{{ route('session.create', $kelas->id) }}"><i class="fas fa-plus mr-2"></i>Tambah Sesi</a>
                        </th>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>