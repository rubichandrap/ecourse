<div class="row">
    <div class="col-12">
        <h2>Token Kelas</h2>
        <div class="form-inline my-4">
            <form id="search-form" action="{{ route('kelas.token_handler') }}" method="POST" class="js-live-search form-inline mb-0 mr-2 w-100">
                @csrf
                <input class="form-control mr-2 w-75" type="text" placeholder="Masukkan Token" name="token" value="" />
                <button type="submit" class="p-2 border-0 bg-transparent">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>
</div>