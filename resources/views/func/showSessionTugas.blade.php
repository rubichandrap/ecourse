<div class="row">
    <div class="col-9">
        <h2>{{ $session->title }} [{{ $session->status == '0' ? 'closed' : 'active' }}] - Tugas</h2>
    </div>
    <div class="col-3 text-right">
        @include('template.showSessionElipsisMenu')
    </div>
</div>
<p class="mb-0">Tugas {{ $session->title }}</p>
<hr class="mt-3 mb-4">
@if($session->status == '1')
<form method="POST" action="{{ route('tugas.store', [$kelas->id, $session->session_of]) }}" enctype="multipart/form-data" class="mb-5">
    @csrf
    <div class="row">
        <div class="col-12">
            <label class="form-control-label">Maximum file size 2mb</label>
        </div>
        <div class="col-9 mb-2">
            <div class="form-group">
                <input class="form-control @error('file') is-invalid @enderror" type="file" name="file" value="{{ old('file') }}">
                @error('file')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-3 ml--4">
            <input id="btn-post" type="submit" class="btn btn-sm btn-primary" value="Submit">
        </div>
        <div class="col-9">
            <div class="form-group">
                <textarea class="form-control @error('content') is-invalid @enderror" type="text" name="content" rows="3" maxlength="255" placeholder="Jelasin tugas atau submission apa yang kamu posting..." style="resize: none;"></textarea>
                @error('content')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
</form>
@endif
@if($tugas->count() > 0)
<div class="row mb-2">
    <div class="col-12 text-right">
        <button id="btn-post-filter" class="btn btn-sm btn-default" type="button" data-parse="{{ Auth::user()->nbm_nim }}">
            Your posts
            <span id="post-toggle">
                <span id="check-icon">
                    <i class="fa fa-check ml-1"></i>
                </span>
                <span id="times-icon" style="display: none;">
                    <i class="fa fa-times ml-1"></i>
                </span>
            </span>
        </button>
    </div>
</div>
@endif
@foreach($tugas as $key)
@php
$split = preg_split('/\//', $key->file);
$pop = array_pop($split);
@endphp
<div class="card mb-3 postings" data-target="{{ $key->user->nbm_nim }}">
    <div class="card-header post-header border-0 pb-0">
        <div class="row align-items-center">
            <div class="col-9">
            <div class="row">
                    <div class="col-12">
                        <div class="d-flex align-items-center">
                            <img class="profile-image rounded-circle mr-2" src="{{ Storage::url($key->user->profile->image) }}" width="40" height="40">
                            <div class="d-inline-block">
                                <p class="mb-0 text-muted" style="font-size:.75rem;">{{ '@'.$key->user->username }}</p>
                                <span>{{ $key->user->name  }}
                                    @if($kelas->user_id == $key->user_id)
                                    <i class="fa fa-star text-yellow ml-1"></i>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3 text-right">
                @if($key->user_id == Auth::user()->id || Auth::user()->hasRole('admin') || $kelas->user_id == Auth::user()->id)
                <a class="post-action-icon" href="#" role="button" id="dropdownPost" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-h"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" aria-labelledby="dropdownPost">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-del{{$key->id}}">Hapus</a>
                </div>
                <form method="POST" action="{{ route('tugas.destroy', $key->id) }}">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE" />

                    <div id="modal-del{{$key->id}}" class="modal fade" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Hapus Posting</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-wrap text-left">Anda yakin ingin menghapus posting ini ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Ya</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
    <div class="card-body post-body pb-3">
        <span>{{ $key->content }}</span>
        <br />
        <a href="{{ Storage::url($key->file) }}" type="download">{{ $pop }}</a>
    </div>
    <div class="card-footer post-footer border-0 pt-0 pb-3">
        <div class="row align-items-center">
            <div class="col-12">
                <ul>
                    <li>
                        <a class="comment-btn" href="#"><i class="fas fa-comment mr-1"></i>Comment</a>
                    </li>
                    <li>
                        <a href="#"><i class="fas fa-thumbs-up mr-1"></i>Like</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="comment-wrapper bg-secondary" style="display: none;">
        <!-- foreach from here -->
        @foreach($tugas_comments as $comment)
        @if($comment->tugas_id == $key->id)
        <div class="pl-4">
            <div class="comment-items">
                <div class="card-header comment-header border-0 pb-0 pt-3">
                    <div class="row">
                        <div class="col-9">
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex align-items-center">
                                        <img class="profile-image rounded-circle mr-2" src="{{ Storage::url($comment->user->profile->image) }}" width="39" height="39">
                                        <div class="d-inline-block">
                                            <p class="mb-0 text-muted" style="font-size:.7rem;">{{ '@'.$comment->user->username }}</p>
                                            <span>{{ $comment->user->name  }}
                                                @if($kelas->user_id == $comment->user_id)
                                                <i class="fa fa-star text-yellow ml-1"></i>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 text-right">
                            @if($comment->user_id == Auth::user()->id || Auth::user()->hasRole('admin') || $kelas->user_id == Auth::user()->id)
                            <a class="post-action-icon" href="#" role="button" id="dropdownPost" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-h"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" aria-labelledby="dropdownPost">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-del{{$comment->id}}">Hapus</a>
                            </div>
                            <form method="POST" action="{{ route('tugas_comment.destroy', $comment->id) }}">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE" />

                                <div id="modal-del{{$comment->id}}" class="modal fade" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Hapus Comment</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-wrap text-left">Anda yakin ingin menghapus comment ini ?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Ya</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body comment-body pb-3">
                    <span>{{ $comment->content }}</span>
                </div>
                <div class="card-footer comment-footer border-0 pt-0 pb-3">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <ul>
                                <li>
                                    <a href="#"><i class="fas fa-comment mr-1"></i>Comment</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fas fa-thumbs-up mr-1"></i>Like</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="m-0">
        @endif
        @endforeach
        <div class="pl-5 py-3">
            @if($session->status == '1')
            <form id="form-comments" method="POST" action="{{route('tugas_comment.store', $key->id)}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-9">
                        <textarea class="form-control" type="text" name="content" maxlength="255" placeholder="Tuliskan Komentar..." style="resize: none;"></textarea>
                    </div>
                    <div class="col-3 ml--4">
                        <input id="btn-post" type="submit" class="btn btn-sm btn-primary" value="Post">
                    </div>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>
@endforeach