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
                                <h3 class="card-title">Tabel Modul</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('modul.create') }}" class="btn btn-sm btn-primary">Add</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                        <table id="table" class="mb-0 table align-items-center table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Lectures</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Publish</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($modul->isEmpty())
                                <tr>
                                    <td id="deflection" class="text-center" colspan="9">Hasil Tidak Ditemukan</td>
                                </tr>
                                @else
                                @php
                                    $i = 1;
                                @endphp
                                @foreach($modul as $key) 
                                <tr>   
                                    <td>{{$i++}}</td>
                                    <td>{{$key->title}}</td>
                                    <td>{{ strip_tags(substr($key->desc, 0, 35)) }}</td>
                                    <td>{{ $arr_lecture[$key->id] }}</td>
                                    <td>
                                        <a href="{{ Storage::url($key->image) }}" target="_blank">Lihat Gambar</a>
                                    </td>
                                    <td>
                                        @if($key->status == '1')
                                            Dipublikasikan
                                        @else
                                            Disembunyikan
                                        @endif
                                    </td>
                                    <td>
                                        <ul>
                                            <li>
                                                <form action="{{ route('modul.status') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input class="mb-1" type="hidden" name="id" value="{{ $key->id }}">
                                                    <input type="hidden" name="status" value="1">
                                                    <button type="submit" class="btn btn-sm btn-default" {{ $key->status == '1' ? 'disabled' : '' }}><i class="fa fa-check" aria-hidden="true"></i></button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('modul.status') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $key->id }}">
                                                    <input type="hidden" name="status" value="0">
                                                    <button type="submit" class="btn btn-sm btn-default" {{ $key->status == '0' ? 'disabled' : '' }}><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                                </form>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li>
                                                <a class="btn btn-sm btn-info" href="{{route('modul.show', $key->slug)}}">Show</a>
                                            </li>
                                            <li>
                                                <a class="btn btn-sm btn-success" href="{{route('modul.edit', $key->slug)}}">Edit</a>
                                            </li>
                                            <li>
                                                <form method="POST" action="{{route('modul.destroy', $key->id)}}">
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
                                                                    <p>Anda yakin ingin menghapus Modul dengan ID : {{$key->id}} ?</p>
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