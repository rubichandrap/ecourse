<div class="row">
    <div class="col-9">
        <h2>{{ $session->title }} [{{ $session->status == '0' ? 'closed' : 'active' }}] - Absen</h2>
    </div>
    <div class="col-3 text-right">
        @include('template.showSessionElipsisMenu')
    </div>
</div>
<p class="mb-0">Daftar absensi {{ $session->title }}</p>
<hr class="mt-3 mb-4">
@if($session->status == '1' && $is_peserta)
<form method="POST" action="{{ route('absent.store', [$kelas->id, $session->session_of]) }}" enctype="multipart/form-data" class="mb-5 w-100">
    @csrf
    <input type="hidden" name="status" value="1">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-8">
                    <h4 class="mb-0">
                        @if($absent > 0)
                        Kamu udah absen<i class="fa fa-check ml-2 text-success"></i>
                        @else
                        Absen dulu yuk, kamu belum absen<i class="fa fa-times ml-2 text-danger"></i>
                        @endif
                    </h4>
                </div>
                <div class="col-4 text-right">
                    <button class="btn btn-sm btn-success {{ $absent > 0 ? 'pointer-events-none' : '' }}" type="submit" name="submit" {{ $absent > 0 ? 'disabled' : '' }}>Absen!</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endif
<div class="form-inline my-4">
    <div id="search-form" class="js-live-search-absent form-inline mb-0 mr-2 w-100">
        <input class="form-control mr-2 w-75" type="text" placeholder="Cari Nama Peserta" value="" />
        <div class="p-2">
            <i class="fas fa-search"></i>
        </div>
    </div>
</div>
<div class="card border-0">
    <table class="table table-responsive-md table-hover js-live-search-table">
        <thead>
            <tr>
                <th scope="col" style="font-size: .8rem !important;">Name</th>
                <th scope="col" style="font-size: .8rem !important;">No. Induk</th>
                <th scope="col" style="font-size: .8rem !important;">Absen</th>
                <th scope="col" style="font-size: .8rem !important;">Waktu Absen</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $key)
            <tr>
                <th scope="row" style="font-size: 1rem !important;">
                    <a>{{ $key->name }}</a>
                </th>
                <td scope="row" style="font-size: 1rem !important;">
                    {{ $key->nbm_nim }}
                </td>
                <td scope="row" style="font-size: 1rem !important;">
                    @if(isset($arr_absents[$key->id]) && $arr_absents[$key->id]->status == '1')
                        Hadir<i class="fa fa-check ml-2 text-success"></i>
                    @endif
                </td>
                <td scope="row" style="font-size: 1rem !important;">
                    @if(isset($arr_absents[$key->id]))
                        {{ date_format($arr_absents[$key->id]->created_at, 'd-m-Y, H:i') }}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>