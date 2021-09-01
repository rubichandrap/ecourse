@extends('layouts.app')

@section('content')
<header>
</header>
<article class="card-post my-5">
    <div class="container">
        @if(\Session::has('success'))
        <div class="alert alert-success">
            <p class="m-0">{{\Session::get('success')}}</p>
        </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <h3 class="card-title">Tabel Dosen</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('dosen.create') }}" class="btn btn-sm btn-primary">Add</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="table" class="mb-0 table align-items-center table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>NBM</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Major</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($dosen->isEmpty())
                                    <tr>
                                        <td id="deflection" class="text-center" colspan="9">Hasil Tidak Ditemukan</td>
                                    </tr>
                                    @else
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach($dosen as $key)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$key->nbm_nim}}</td>
                                        <td>{{$key->name}}</td>
                                        <td>@if($key->username == '')
                                            -
                                            @else
                                            {{ $key->username }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($key->majors->count() > 0)
                                            @if($key->majors->count() > 1)
                                            @for ($i = 0; $i < $key->majors->count(); $i++)
                                                {{ $key->majors[$i]->name }},
                                                @endfor
                                                @else
                                                {{ $key->majors[0]->name }}
                                                @endif
                                                @else
                                                -
                                                @endif
                                        </td>
                                        <td>{{$key->email}}</td>
                                        <td>
                                            @if($key->roles->count() > 0)
                                            @if($key->roles->count() > 1)
                                            @for ($i = 0; $i < $key->roles->count(); $i++)
                                                {{ $key->roles[$i]->name }},
                                                @endfor
                                                @else
                                                {{ $key->roles[0]->name }}
                                                @endif
                                                @else
                                                -
                                                @endif
                                        </td>
                                        <td>
                                            @if($key->status == '1')
                                            Aktif
                                            @else
                                            Non-Aktif
                                            @endif
                                        </td>
                                        <td>
                                            <ul>
                                                <li>
                                                    <a class="btn btn-sm btn-info" href="/dosen/{{$key->id}}">Show</a>
                                                </li>
                                                <li>
                                                    <a class="btn btn-sm btn-success" href="{{route('dosen.edit', $key->id)}}">Edit</a>
                                                </li>
                                                <li>
                                                    <form method="POST" action="{{route('dosen.destroy', $key->id)}}">
                                                        @csrf
                                                        <input type="hidden" name="_method" value="DELETE" />
                                                        <button class="btn btn-sm btn-danger del-btn" type="button" data-toggle="modal" data-target="#modal-del{{$key->id}}">Delete</button>
                                                        <div id="modal-del{{$key->id}}" class="modal fade" tabindex="-1" role="dialog">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Hapus Data</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Anda yakin ingin menghapus dosen dengan ID : {{$key->id}} ?</p>
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>
@endsection