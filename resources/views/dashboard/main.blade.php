@extends('app.dashboard')
@section('title', 'Main')

@include('dashboard.js.main')

@section('content')


<div class="main-content-container container-fluid px-4">
    <!-- Page Header -->
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">Dashboard</span>
            <h3 class="page-title">Blog Overview</h3>
        </div>
    </div>



    @if ($user->status != 1)

    <div class="alert alert-warning d-flex align-items-center" role="alert">
        <svg width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"
            viewBox="0 0 16 16" role="img" aria-label="Warning:">
            <path
                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </svg>
        <div class="px-2">
            Anda belum resmi menjadi pengurus Himanika. Unduh aplikasi simanika untuk memantau tanggal dan waktu wawancara.
        </div>
    </div>

    @endif


    <!-- End Page Header -->

    @if ($user->level_id == 1)

    <div class="row">
        <!-- Users Stats -->
        <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0">Anggota Baru</h6>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive mt-3">
                        <table class="table table-member mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col" class="border-0">No</th>
                                    <th scope="col" class="border-0">Nama Lengkap</th>
                                    <th scope="col" class="border-0">NIM</th>
                                    <th scope="col" class="border-0">Angkatan</th>
                                    <th scope="col" class="border-0">Email</th>
                                    <th scope="col" class="border-0">Telp</th>
                                    <th scope="col" class="border-0">Wawancara</th>
                                    <th scope="col" class="border-0">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endif

    <div class="row">
        <!-- Users Stats -->
        <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0">Artikel</h6>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive mt-3">
                        <table class="table table-new-article mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col" class="border-0">No</th>
                                    <th scope="col" class="border-0">Judul</th>
                                    <th scope="col" class="border-0">Sampul</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($user->status == 1)
    <div class="row">
        <!-- Users Stats -->
        <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0">Rapat Bulan Ini</h6>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive mt-3">
                        <table class="table table-meeting-this-month mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col" class="border-0">No</th>
                                    <th scope="col" class="border-0">Tipe Agenda Rapat</th>
                                    <th scope="col" class="border-0">Nama Agenda Rapat</th>
                                    <th scope="col" class="border-0">Divisi</th>
                                    <th scope="col" class="border-0">Waktu</th>
                                    <th scope="col" class="border-0">Notulensi</th>
                                    <th scope="col" class="border-0">Presensi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Users Stats -->
        <!-- Users By Device Stats -->
        <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
            <div class="card card-small h-100">
                <div class="card-header border-bottom">
                    <h6 class="m-0">Statistik Rapat Per Tahun</h6>
                </div>
                <div class="card-body d-flex p-3 row">
                    <div class="col-12 mb-3">
                        <label class="fw-bold">Pilih Tahun:</label>
                        <select class="form-control select-statistics-year">
                            <?php

                  				$currentYear = date("Y");

								// Membuat perulangan tahun 2010 sampai tahun sekarang
								for ($year = 2021; $year <= $currentYear; $year++) {
									if ($year == $currentYear) {
	  									echo "<option value='$year' selected>Tahun $year</option>";
									} else {
	  									echo "<option value='$year'>Tahun $year</option>";
									}
								}

                  			?>
                        </select>
                    </div>
                    <div id="chartdiv" style="width: 100%; height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- CRUD Modal -->
<div class="modal fade" id="wawancaraModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Set Wawancara <span
                        class="wawancara-member-name"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-0">
                <form>
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Tanggal Wawancara</label>
                            <input type="date" class="form-control" id="tanggalWawancara" placeholder="Tanggal">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Waktu Wawancara</label>
                            <input type="time" class="form-control" id="waktuWawancara" placeholder="Tanggal">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-confirm-set-wawancara">Set Tanggal</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- CRUD Modal -->
<div class="modal fade" id="setujuiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Setujui <span class="setujui-member-name"></span>
                    Menjadi Anggota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-0">
                <form>
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="division">Divisi</label>
                            <select id="division" class="form-control" style="width: 100%">
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="position">Jabatan</label>
                            <select id="position" class="form-control" style="width: 100%">
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-confirm-setujui">Setujui</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




@endsection
