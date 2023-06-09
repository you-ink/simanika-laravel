@extends('app.dashboard')
@section('title', 'Presensi Meeting')

@include('dashboard.js.presensi')

@section('content')

<div class="main-content-container container-fluid px-4">
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">PRESENSI MEETING</span>
            <h3 class="page-title">Data Presensi Meeting</h3>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card card-small mb-4">
                <div class="card-header border-bottom">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="m-0">Data Presensi <span id="meeting-name"></span></h6>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3 text-left">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col" class="border-0">No</th>
                                    <th scope="col" class="border-0">Nama</th>
                                    <th scope="col" class="border-0">Foto</th>
                                    <th scope="col" class="border-0">Peran</th>
                                    <th scope="col" class="border-0">Waktu Hadir</th>
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
</div>

@endsection
