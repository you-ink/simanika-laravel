@extends('app.dashboard')
@section('title', 'User_Profile')

@include('dashboard.js.User_Profile')

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
						src="<?php echo url('assets/img/user.png')?>" alt="User Avatar" width="150" height="150">
					</div>
					<h4 class="mb-0"><?php echo "bubu" ?></h4>
					<span class="text-muted d-block mb-2"></span>
					<button type="button" class="mb-2 btn btn-sm btn-pill btn-outline-primary mr-2" data-toggle="modal"
						data-target="#crudModal"><i class="fas fa-pen mr-1"></i>Edit</button>
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
											<input type="text" class="form-control" id="nama" placeholder="Nama lengkap" value="<?php echo "bubu" ?>"> 
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-6">
											<label for="nim">NIM</label>
											<input type="text" class="form-control" id="nim" placeholder="NIM" value="<?php echo "E31234567" ?>" readonly> 
										</div>
										<div class="form-group col-md-6">
											<label for="angkatan">Angkatan</label>
											<input type="text" class="form-control" id="angkatan" placeholder="Angkatan" value="<?php echo "21" ?>"> 
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-6">
											<label for="email">Email</label>
											<input type="email" class="form-control" id="email" placeholder="Email" value="<?php echo "bubu@gmail.com" ?>" readonly> 
										</div>
										<div class="form-group col-md-6">
											<label for="telp">No Telepon</label>
											<input type="text" class="form-control" id="telp" placeholder="No. Hanphone" value="<?php echo "0888888888" ?>"> 
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-12">
											<label for="alamat">Alamat</label>
											<textarea class="form-control" id="alamat" rows="3"><?php echo "jonggol" ?></textarea>
										</div>
									</div>
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
																Lihat File</a>
															</div>
														</td>
													</tr>
												</table>
											</div>
										</div>
									</div>
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

<!-- CRUD Modal -->
<div class="modal fade" id="crudModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
	aria-hidden="true" data-backdrop="false">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Update Foto Profile</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-row upload--foto">
						<div class="form-group col-12">
							<input id="foto" type="file" accept=".png, .jpeg, .jpg">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary btn--upload-foto">Update</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>



@endsection
