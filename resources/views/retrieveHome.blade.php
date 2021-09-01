@foreach ($modul as $key)
<div class="col-12 col-md-6 col-lg-4 mb-4 d-flex">
    <div class="card card-shadow rounded">
        <a class="courses text-dark" href="{{ route('modul.show', $key->slug) }}">
            <img class="card-img" src="{{ Storage::url($key->image) }}">
            <div class="card-body">
                <h4 class="card-title font-weight-bold mb-2">{{ $key->title }}</h4>
               {{--  <div class="row">
                    <div class="col-6 mb-1">
                        <span class="text-muted"><i class="fas fa-layer-group mr-2"></i>{{ $key->level }}</span>
                    </div>
                    <div class="col-6 mb-1">
                        <span class="text-muted"><i class="fas fa-desktop mr-2"></i>{{ $key->platform }}</span>
                    </div>
                    <div class="col-6">
                        <span class="text-muted"><i class="fas fa-bookmark mr-2"></i>{{ $key->lectures_count }} Materi</span>
                    </div>
                    <div class="col-6">
                        <span class="text-muted"><i class="fas fa-user mr-2"></i>rubichandrap</span>
                    </div>
                </div> --}}
            </div>
        </a>
    </div>
</div>
@endforeach