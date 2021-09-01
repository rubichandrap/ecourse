<div class="row">
    <div class="col-12">
        <h2>Daftar Kelas</h2>
        <div class="form-inline my-4">
            <div id="search-form" class="js-live-search form-inline mb-0 mr-2 w-100">
                <input class="form-control mr-2 w-75" type="text" placeholder="Cari Kelas" name="search_input_materi" value="" />
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
                        <th scope="col" style="font-size: .8rem !important;">Dosen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kelas as $key)
                    <tr>
                        <th scope="row" style="font-size: 1rem !important;">
                            <a href="{{ route('kelas.show', $key->id) }}">
                                {{ $key->title }}
                            </a>
                        </th>
                        <td scope="row" style="font-size: 1rem !important;">
                            {{ $key->user->name }}<i class="fa fa-star ml-2 text-yellow"></i>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>