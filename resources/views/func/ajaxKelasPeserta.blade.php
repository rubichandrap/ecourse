<div class="row">
    <div class="col-12">
        <h2>Daftar Peserta</h2>
        <div class="form-inline my-4">
            <div id="search-form" class="js-live-search form-inline mb-0 mr-2 w-100">
                <input class="form-control mr-2 w-75" type="text" placeholder="Cari Nama Peserta" name="search_input_materi" value="" />
                <div class="p-2">
                    <i class="fas fa-search"></i>
                </div>
            </div>
        </div>
        <div class="card border-0">
            <table class="table table-responsive-sm table-hover js-live-search-table">
                <thead>
                    <tr>
                        <th scope="col" style="font-size: .8rem !important;">Name</th>
                        <th scope="col" style="font-size: .8rem !important;">No. Induk</th>
                        <th scope="col" style="font-size: .8rem !important;">Role</th>
                        @if(Auth::user()->hasRole('admin') || (Auth::user()->hasRole('dosen') && $user_host->user->id == Auth::user()->id ))
                        <th scope="col" style="font-size: .8rem !important;">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row" style="font-size: 1rem !important;">
                            <a>{{$user_host->user->name }}</a>
                        </th>
                        <td scope="row" style="font-size: 1rem !important;">
                            {{ $user_host->user->nbm_nim }}
                        </td>
                        <td scope="row" style="font-size: 1rem !important;">
                            Dosen<i class="fa fa-star ml-2 text-yellow"></i>
                        </td>
                        <td scope="row" style="font-size: 1rem !important;">
                            &nbsp;
                        </td>
                    </tr>
                    @foreach($user_dosen as $key)
                    @if($key->id != $kelas->user_id)
                    <tr>
                        <th scope="row" style="font-size: 1rem !important;">
                            <a>{{ $key->name }}</a>
                        </th>
                        <td scope="row" style="font-size: 1rem !important;">
                            {{ $key->nbm_nim }}
                        </td>
                        <td scope="row" style="font-size: 1rem !important;">
                            Dosen
                        </td>
                        @if(Auth::user()->hasRole('admin') || (Auth::user()->hasRole('dosen') && $user_host->user->id == Auth::user()->id ))
                        <td scope="row" style="font-size: 1rem !important;">
                            <form method="POST" action="#">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE" />
                                <button class="btn btn-sm btn-danger del-btn" type="button" data-toggle="modal" data-target="#modal-del{{$key->id}}">Kick!</button>
                                <div id="modal-del{{$key->id}}" class="modal fade" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Kick Peserta</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-wrap">Anda yakin ingin menendang user dengan no. induk : {{$key->nbm_nim}} ?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Ya</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @endif
                    @endforeach
                    @foreach($user_mahasiswa as $key)
                    <tr>
                        <th scope="row" style="font-size: 1rem !important;">
                            <a>{{ $key->name }}</a>
                        </th>
                        <td scope="row" style="font-size: 1rem !important;">
                            {{ $key->nbm_nim }}
                        </td>
                        <td scope="row" style="font-size: 1rem !important;">
                            Mahasiswa
                        </td>
                        @if(Auth::user()->hasRole('admin') || (Auth::user()->hasRole('dosen') && $user_host->user->id == Auth::user()->id ))
                        <td scope="row" style="font-size: 1rem !important;">
                            <form method="POST" action="{{ route('kelas.kick_peserta', [$kelas->id, $key->id]) }}">
                                @csrf
                                <input type="hidden" name="_method" value="PATCH" />
                                <button class="btn btn-sm btn-danger del-btn" type="button" data-toggle="modal" data-target="#modal-del{{$key->id}}">Kick!</button>
                                <div id="modal-del{{$key->id}}" class="modal fade" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Kick Peserta</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-wrap">Anda yakin ingin menendang user dengan no. induk : {{$key->nbm_nim}} ?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Ya</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>