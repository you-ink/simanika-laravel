@extends('app.dashboard')
@section('title', 'User_Profile')

@include('dashboard.js.user_profile')

@section('content')


<div class="main-content-container container-fluid px-4">
	<div class="page-header row no-gutters py-4">
		<div class="col-12 col-sm-4 text-center text-sm-left mb-0">
			<span class="text-uppercase page-subtitle">Profile</span>
			<h3 class="page-title">User Profile</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4">
			<div class="card card-small mb-4 pt-3">
				<div class="card-header border-bottom text-center">
					<div class="mb-3 mx-auto">
						<img class="user-avatar rounded-circle mr-2"
						src="{{ url($user->detailUser->foto) }}" alt="User Avatar" width="150" height="150">
					</div>
					<h4 class="mb-0">{{ $user->nama }}</h4>
                    @if ($user->status == 1)
					    <span class="text-muted d-block mb-2">{{ $user->detailUser->divisi->nama." ● ".$user->detailUser->jabatan->nama }}</span>
                    @endif
				</div>
			</div>
		</div>
		<div class="col-lg-8">
			<div class="card card-small mb-4">
				<div class="card-header border-bottom">
					<h6 class="m-0">Account Details</h6>
				</div>
				<ul class="list-group list-group-flush">
					<li class="list-group-item p-3">
						<div class="row">
							<div class="col">
								<form>
									<div class="form-row">
										<div class="form-group col-md-12">
											<label for="nama">Nama Lengkap</label>
											<input type="text" class="form-control" id="nama" placeholder="Nama lengkap" value="{{ $user->nama }}">
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-6">
											<label for="nim">NIM</label>
											<input type="text" class="form-control" id="nim" placeholder="NIM" value="{{ $user->nim }}" readonly>
										</div>
										<div class="form-group col-md-6">
											<label for="angkatan">Angkatan</label>
											<input type="text" class="form-control" id="angkatan" placeholder="Angkatan" value="{{ $user->angkatan }}">
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-6">
											<label for="email">Email</label>
											<input type="email" class="form-control" id="email" placeholder="Email" value="{{ $user->email }}" readonly>
										</div>
										<div class="form-group col-md-6">
											<label for="telp">No Telepon</label>
											<input type="text" class="form-control" id="telp" placeholder="No. Hanphone" value="{{ $user->telp }}">
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-12">
											<label for="alamat">Alamat</label>
											<textarea class="form-control" id="alamat" rows="3">{{ $user->alamat }}</textarea>
										</div>
									</div>
                                    <div class="form-row upload--foto">
                                        <div class="form-group col-12">
                                            <label for="nama">Foto Profile</label>
                                            <input id="foto" type="file" accept=".png, .jpeg, .jpg">
                                        </div>
                                    </div>
                                    @if (!empty($user->detailUser->bukti_mahasiswa) || !empty($user->detailUser->bukti_kesanggupan))
									<div class="form-row">
										<div class="form-group col-md-6">
											<div class="ff_fileupload_wrap">
												<table class="ff_fileupload_uploads">
													<tr class="">
														<td class="ff_fileupload_preview">
															<button class="ff_fileupload_preview_image ff_fileupload_preview_text_with_color ff_fileupload_preview_text_d" type="button" disabled="" aria-label="No preview available">File</button>
														</td>
														<td class="ff_fileupload_summary">
															<div class="ff_fileupload_filename w-100" id="buktiMahasiswaNama">
																Bukti Kesanggupan
															</div>
															<div class="ff_fileupload_fileinfo" id="buktiMahasiswaInfo">
                                                                <a href="{{ url($user->detailUser->bukti_kesanggupan) }}">Lihat File</a>
															</div>
														</td>
													</tr>
												</table>
											</div>
										</div>
										<div class="form-group col-md-6">
											<div class="ff_fileupload_wrap">
												<table class="ff_fileupload_uploads">
													<tr class="">
														<td class="ff_fileupload_preview">
															<button class="ff_fileupload_preview_image ff_fileupload_preview_text_with_color ff_fileupload_preview_text_d" type="button" disabled="" aria-label="No preview available">File</button>
														</td>
														<td class="ff_fileupload_summary">
															<div class="ff_fileupload_filename w-100" id="buktiMahasiswaNama">
																Bukti Mahasiswa
															</div>
															<div class="ff_fileupload_fileinfo" id="buktiMahasiswaInfo">
																<a href="{{ url($user->detailUser->bukti_mahasiswa) }}">Lihat File</a>
															</div>
														</td>
													</tr>
												</table>
											</div>
										</div>
									</div>
                                    @endif
									<button type="submit" class="btn btn-accent btn-update-profile">Update Profile</button>
								</form>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>

@endsection
