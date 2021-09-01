@extends('layouts.app')

@section('content')

<header>
</header>
<article class="card-post my-5 no-select">
	<!-- Page content -->
	<div class="container">
		@if(\Session::has('success'))
		<div class="alert alert-success">
			<p class="m-0">{{\Session::get('success')}}</p>
		</div>
		@endif
		<a class="d-inline-block pb-2" href="javascript:history.back()"><i class="fa fa-arrow-left mr-2"></i>Kembali</a>
		<div class="row">
			<div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
				<div class="card card-profile shadow">
					<div class="row justify-content-center">
						<div class="col-lg-3 order-lg-2">
							<div class="card-profile-image">
								<a href="#">
									<img src="{{ Storage::url($profile->image) }}" class="rounded-circle">
								</a>
							</div>
						</div>
					</div>
					<div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
					</div>
					<div class="card-body pt-2 pt-md-7 pt-lg-7">
						<div class="text-center">
							<h3>
								{{ $user->name }}
							</h3>
							<div class="h5 font-weight-300">
								<i class="fas fa-map-marked-alt mr-2"></i>
								@if(!$profile->alamat == '')
								{{ $profile->alamat }}
								@else
								Belum Tersimpan
								@endif
							</div>
							<div class="h5 mt-4">
								<i class="fas fa-business-time mr-2"></i>
								@if(!$profile->pekerjaan == '')
								{{ $profile->pekerjaan }}
								@else
								Belum Tersimpan
								@endif
							</div>
							<div>
								<i class="fas fa-graduation-cap mr-2"></i>STMIK Muhammadiyah Jakarta
							</div>
							<hr class="my-4" />

							<a href="#">Show more</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-8 order-xl-1">
				<div class="card bg-secondary shadow">
					<form id="form-edit" action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="_method" value="PATCH" />
						@csrf
						<div class="card-header bg-white border-0">
							<div class="row align-items-center">
								<div class="col-6">
									<h3 class="mb-0">Detail akun</h3>
								</div>
								<div class="col-6 text-right">
									<a class="btn btn-sm btn-default mr-0 mr-md-2" href="{{ route('password.edit', $user->id) }}">Ubah Password</a>
									<input id="btn-save" type="submit" class="btn btn-sm btn-primary" value="Simpan">
								</div>
							</div>
						</div>
						<div id="form-body" class="card-body">

							<h6 class="heading-small text-muted mb-4">Informasi User</h6>
							<div class="pl-lg-4">
								<div class="row">
									<div class="col-lg-6 mb-2">
										<div class="form-group">
											<label class="form-control-label" for="input-nbm-nim">NIM</label>
											<input type="text" id="input-nbm-nim" class="form-control form-control-alternative" name="nbm_nim" value="{{ $user->nbm_nim }}" placeholder="000001" readonly>
										</div>
									</div>
									<div class="col-lg-6 mb-2">
										<div class="form-group">
											<label class="form-control-label" for="input-username">Username</label>
											<input type="text" id="input-username" class="form-control form-control-alternative" name="username" value="{{ $user->username}}" placeholder="johndoe" readonly>
										</div>
									</div>
									<div class="col-lg-6 mb-2">
										<div class="form-group">
											<label class="form-control-label" for="input-name">Nama</label>
											<input type="text" id="input-name" class="form-control form-control-alternative" name="name" value="{{ $user->name }}" placeholder="John Doe" readonly>
										</div>
									</div>
									<div class="col-lg-6 mb-2">
										<div class="form-group">
											<label class="form-control-label" for="input-major">Major</label>
											<input type="text" id="input-major" class="form-control form-control-alternative" name="major" value="{{ $user->majors->count() > 0 ? $user->majors[0]->name : '-' }}" placeholder="Sistem Informasi" readonly>
										</div>
									</div>
									<div class="col-lg-6 mb-2">
										<div class="form-group">
											<label class="form-control-label" for="input-email">Email</label>
											<input type="text" id="input-email" class="form-control form-control-alternative" name="email" value="{{ $user->email }}" placeholder="johndoe@example.com" readonly>
										</div>
									</div>
									<div class="col-lg-6 mb-2">
										<div class="form-group">
											<label class="form-control-label" for="input-role">Role</label>
											<input type="text" id="input-role" class="form-control form-control-alternative" name="role" value="{{ $user->roles[0]->name }}" placeholder="johndoe@example.com" readonly>
										</div>
									</div>
								</div>
							</div>
							<hr class="my-4" />
							<!-- Address -->
							<h6 class="heading-small text-muted mb-4">Informasi Tambahan</h6>
							<div class="pl-lg-4">
								<div class="row">
									<div class="col-lg-4 mb-2">
										<div class="form-group">
											<label class="form-control-label" for="input-pekerjaan">Pekerjaan</label>
											<input type="text" id="input-pekerjaan" class="form-control form-control-alternative" name="pekerjaan" value="{{ $profile->pekerjaan }}" placeholder="Developer">
										</div>
									</div>
									<div class="col-lg-4 mb-2">
										<div class="form-group">
											<label class="form-control-label" for="input-tempatLahir">Tempat Lahir</label>
											<input type="text" id="input-tempat-lahir" class="form-control form-control-alternative" name="tempat_lahir" value="{{ $profile->tempat_lahir }}" placeholder="Jakarta">
										</div>
									</div>
									<div class="col-lg-4 mb-2">
										<div class="form-group">
											<label class="form-control-label" for="input-tanggalLahir">Tanggal Lahir</label>
											<input type="date" id="input-tanggal-lahir" class="form-control form-control-alternative" name="tanggal_lahir" value="{{ $profile->tanggal_lahir }}" placeholder="">
										</div>
									</div>
									<div class="col-md-12 mb-2">
										<div class="form-group">
											<label class="form-control-label" for="input-alamat">Alamat</label>
											<input type="text" id="input-alamat" class="form-control form-control-alternative" name="alamat" value="{{ $profile->alamat }}" placeholder="JL. ABC Blok II Jakarta Utara">
										</div>
									</div>
								</div>
							</div>
							<hr class="my-4" />
							<!-- Description -->
							<h6 class="heading-small text-muted mb-4">About me</h6>
							<div class="pl-lg-4">
								<div class="form-group">
									<label class="form-control-label" for="about-me">About Me</label>
									<textarea name="about" rows="4" class="form-control form-control-alternative" placeholder="A few words about you ..." style="resize:none;">{{ $profile->about }}</textarea>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</article>

@endsection