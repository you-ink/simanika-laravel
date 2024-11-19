<!doctype html>
<html class="no-js h-100" lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Dashboard - @yield('title')</title>
    <meta name="description" content="Official website Himpunan Mahasiswa Teknik Informatika (Himanika) POLIJE.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Authorization" content="Bearer {{ $_COOKIE['token'] }}">
    <link rel="icon" href="'assets/img/logo2-himanika.png'" type="image/icon type">

    <link href="<?= url('/assets/css/main.css') ?>" rel="stylesheet">
    <link href="<?= url('/assets/plugin/fontawesome/css/all.min.css') ?>" rel="stylesheet">
    <link href="<?= url('/assets/plugin/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= url('/assets/template/shards-dashboard/styles/extras.1.1.0.min.css') ?>" rel="stylesheet">
    <link href="<?= url('/assets/plugin/DataTables/datatables.min.css') ?>" rel="stylesheet">
    <link href="<?= url('/assets/plugin/select2/css/select2.min.css') ?>" rel="stylesheet">
    <link href="<?= url('/assets/plugin/fancy-file-uploader/fancy_fileupload.css') ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.1.0"
        href="<?php echo url('assets/template/shards-dashboard/styles/shards-dashboards.1.1.0.min.css') ?>">

    <style>
        .modal {
            background-color: rgba(0, 0, 0, .3);
        }
    </style>
</head>

<body class="h-100">
    <div class="container-fluid">
        <div class="row">
            <!-- Main Sidebar -->
            <aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
                <div class="main-navbar">
                    <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
                        <a class="navbar-brand w-100 mr-0" href="<?php echo url('dashboard') ?>"
                            style="line-height: 25px;">
                            <div class="d-table m-auto">
                                <img id="main-logo" class="d-inline-block align-top mr-1" style="max-width: 25px;"
                                    src="<?php echo url('assets/img/logo.png') ?>" alt="simanika">
                                <span class="d-none d-md-inline ml-1">SIMANIKA</span>
                            </div>
                        </a>
                        <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
                            <i class="material-icons">&#xE5C4;</i>
                        </a>
                    </nav>
                </div>
                <form action="#" class="main-sidebar__search w-100 border-right d-sm-flex d-md-none d-lg-none">
                    <div class="input-group input-group-seamless ml-3">
                        <div class="input-group-prepend">
                            <!-- <div class="input-group-text">
          <i class="fas fa-search"></i>
        </div> -->
                        </div>
                        <input class="navbar-search form-control" type="text" placeholder="Search for something..."
                            aria-label="Search">
                    </div>
                </form>
                <div class="nav-wrapper">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?php echo ( request()->segment(2) == 'index' || empty( request()->segment(2)) == 'index')?'active':'' ?>"
                                href="<?php echo url('dashboard') ?>">
                                <i class="material-icons">home</i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        @if ($user->status == 1)
                        <li class="nav-item">
                            <a class="nav-link <?php echo (request()->segment(2) == 'meeting' || request()->segment(2) == 'presensi')?'active':'' ?>"
                                href="<?php echo url('dashboard/meeting') ?>">
                                <i class="material-icons">groups</i>
                                <span>Rapat</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?php echo (request()->segment(2) == 'artikel')?'active':'' ?>"
                                href="<?php echo url('dashboard/artikel') ?>">
                                <i class="material-icons">toc</i>
                                <span>Artikel</span>
                            </a>
                        </li>

                        @if ($user->level_id == 1)
                        <li class="nav-item">
                            <a class="nav-link <?php echo (request()->segment(2) == 'member')?'active':'' ?>"
                                href="<?php echo url('dashboard/member') ?>">
                                <i class="material-icons">table_chart</i>
                                <span>Data Anggota</span>
                            </a>
                        </li>
                        @endif
                        @endif


                        <li class="nav-item">
                            <a class="nav-link <?php echo (request()->segment(2) == 'notifikasi')?'active':'' ?>"
                                href="<?php echo url('dashboard/notifikasi') ?>">
                                <i class="material-icons">&#xE7F4;</i>
                                <span>Notifikasi</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?php echo (request()->segment(2) == 'user_profile')?'active':'' ?>"
                                href="<?php echo url('dashboard/user_profile') ?>">
                                <i class="material-icons">person</i>
                                <span>User Profile</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </aside>
            <!-- End Main Sidebar -->
            <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">
                <div class="main-navbar sticky-top bg-white">
                    <!-- Main Navbar -->
                    <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
                        <form action="#" class="main-navbar__search w-100 d-none d-md-flex d-lg-flex">
                            <div class="input-group input-group-seamless ml-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <!-- <i class="fas fa-search"></i> -->
                                    </div>
                                </div>
                                <div class="navbar-search" type="text" placeholder="" aria-label="Search"></div>
                            </div>
                        </form>
                        <ul class="navbar-nav border-left flex-row ">


                            <li class="nav-item border-right dropdown notifications">
                                <a class="nav-link nav-link-icon text-center" href="#" role="button"
                                    id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <div class="nav-link-icon__wrapper">
                                        <i class="material-icons">&#xE7F4;</i>
                                        <span class="badge badge-pill badge-danger jumlah-notif-terbaru"></span>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-small" aria-labelledby="dropdownMenuLink">
                                    <section class="notif-terbaru">

                                    </section>
                                    <a class="dropdown-item notification__all text-center"  href="<?php echo url('dashboard/notifikasi') ?>"> View all
                                        Notifications </a>
                                </div>
                            </li>



                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#"
                                    role="button" aria-haspopup="true" aria-expanded="false">
                                    <img class="user-avatar rounded-circle mr-2"
                                        src="{{ url($user->detailUser->foto) }}" alt="User Avatar"
                                        style="width: 2.5rem !important; height: 2.5rem !important;">
                                    <span class="d-none d-md-inline-block">{{ $user->nama }}</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-small">
                                    <a class="dropdown-item" href="<?php echo url('dashboard/user_profile') ?>">
                                        <i class="material-icons">&#xE7FD;</i> Profile
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger btn-logout" href="void(0):javascript;">
                                        <i class="material-icons text-danger">&#xE879;</i> Logout
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <nav class="nav">
                            <a href="#"
                                class="nav-link nav-link-icon toggle-sidebar d-md-inline d-lg-none text-center border-left"
                                data-toggle="collapse" data-target=".header-navbar" aria-expanded="false"
                                aria-controls="header-navbar">
                                <i class="material-icons">&#xE5D2;</i>
                            </a>
                        </nav>
                    </nav>
                </div>
                <!-- / .main-navbar -->

                <!-- ISI -->
                @yield('content')

                @if (empty($user->detailUser->bukti_mahasiswa) || empty($user->detailUser->bukti_kesanggupan))
                <div class="modal fade" style="background-color: rgba(0, 0, 0, .7) !important" id="lengkapiProfileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                aria-hidden="true" data-backdrop="false">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Lengkapi Data Profile</h5>
                            </div>
                            <div class="modal-body">
                                <form>
									<div class="form-row">
										<div class="form-group col-md-12">
											<label for="alamat">Alamat</label>
											<textarea class="form-control" id="lengkapi_alamat" rows="3"></textarea>
										</div>
									</div>
                                    <div class="form-row upload--foto">
                                        <div class="form-group col-12">
                                            <label for="nama">Bukti Mahasiswa</label>
                                            <input id="lengkapi_bukti_mahasiswa" type="file" accept=".png, .jpeg, .jpg, .pdf">
                                        </div>
                                    </div>
                                    <div class="form-row upload--foto">
                                        <div class="form-group col-12">
                                            <label for="nama">Bukti Kesanggupan</label>
                                            <input id="lengkapi_bukti_kesanggupan" type="file" accept=".png, .jpeg, .jpg, .pdf">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary btn--lengkapi-profile">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <footer class="main-footer d-flex p-2 px-3 bg-white border-top">
                    <span class="copyright ml-auto my-auto mr-2">Copyright &copy; 2023
                        <a href="<?php echo url('/') ?>" rel="nofollow">Simanika</a>
                    </span>
                </footer>
            </main>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sharrre/2.0.1/jquery.sharrre.min.js"></script>
    <script src="<?= url('assets/js/jquery-3.6.1.min.js') ?>"></script>
    <script src="<?= url('assets/plugin/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= url('assets/plugin/chartjs/Chart.min.js') ?>"></script>
    <script src="<?= url('assets/plugin/shards-ui/js/shards.min.js') ?>"></script>
    <script src="<?= url('assets/template/shards-dashboard/scripts/shards-dashboards.1.1.0.min.js') ?>"></script>
    <script src="<?= url('assets/plugin/DataTables/datatables.min.js') ?>"></script>
    <script src="<?= url('assets/plugin/sweetalert2/sweetalert2.all.min.js') ?>"></script>
    <script src="<?= url('assets/plugin/select2/js/select2.min.js') ?>"></script>
    <script src="<?= url('assets/plugin/fancy-file-uploader/jquery.ui.widget.js') ?>"></script>
    <script src="<?= url('assets/plugin/fancy-file-uploader/jquery.fileupload.js') ?>"></script>
    <script src="<?= url('assets/plugin/fancy-file-uploader/jquery.iframe-transport.js') ?>"></script>
    <script src="<?= url('assets/plugin/fancy-file-uploader/jquery.fancy-fileupload.js') ?>"></script>
    <script src="<?= url('assets/js/jquery-cookie.min.js') ?>"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>

    <script>
        function getAuthorization() {
            return "Bearer "+cookie.get("token");
        }
    </script>

    <script src="<?= url('assets/js/dashboard-main.js') ?>"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('5d8e462327809b06a3fe', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('simanika-channel');
        channel.bind('simanika-event', function(data) {
            let jumlah = $('.jumlah-notif-terbaru').html();
            if (jumlah) {
                jumlah = parseInt(jumlah)
            } else {
                jumlah = 0;
            }
            $('.jumlah-notif-terbaru').html(jumlah+1);
            load_notifikasi();
        });

        function load_notifikasi(){
            callApi("GET", "{{ route('api.notifikasi.index') }}?length=5&start=0", null, function(req) {
                notifikasi = '';
                $.each(req.data, function(index, val) {
                    notifikasi += `<a class="dropdown-item" href="#">
                                    <div class="notification__icon-wrapper">
                                        <div class="notification__icon">
                                            <i class="material-icons">&#xE7F7;</i>
                                        </div>
                                    </div>
                                    <div class="notification__content">
                                        <span class="notification__category">${val.judul}</span>
                                        <p>${val.isi}</p>
                                        <p><span class="text-secondary text-semibold">${new Date(val.created_at).toLocaleString()}</span></p>
                                    </div>
                                </a>`;
                });

                $(".notif-terbaru").html(notifikasi);
            })
        }

        load_notifikasi();
    </script>
    <script>
        var getUploadedFile = {};
        // Function For Upload File
        function upload(name, maxFiles = 1) {
            getUploadedFile[name] = [];

            $(`#${name}`).FancyFileUpload({
            params : {
                action : 'fileuploader'
            },
            edit: false,
            maxfilesize : 10000000,
            added: function (e, data) {
                if (data.ff_info.errors.length > 0) {
                Swal.fire(
                    'Gagal Ditambahkan!',
                    'Error: '+data.ff_info.errors,
                    'error'
                    )
                    $(this).remove()
                    delete data.ff_info
                    return;
                }

                if ($(`.upload--${name}`).find('.ff_fileupload_queued').length > maxFiles) {
                    Swal.fire(
                        'Gagal Ditambahkan!',
                        `Maksimal upload hanya ${maxFiles} file`,
                        'error'
                        )
                    $(this).remove()
                    delete data.ff_info
                    return;
                }

                $(`.upload--${name}`).find('.btn--upload-file').removeClass('d-none');
                $(`.upload--${name}`).find('.ff_fileupload_remove_file').attr('data-doc', name);

                if (maxFiles === 1) {
                    getUploadedFile[name] = data.files[0];
                } else {
                    for (var i = 0; i < maxFiles; i++) {
                        if (($(`.upload--${name}`).find('.ff_fileupload_queued').length-1) == i) {
                            getUploadedFile[name][i] = data.files[0];
                        }
                    }
                }

                $(this).find('.ff_fileupload_start_upload').remove()
            }
            });
        }
    </script>

    @stack('script')

    <script>
        // Change Datatable Button
      function change_datatable_button() {
        $('.dt-button').removeClass("dt-button");
      }

      $(document).ready(function() { 
        change_datatable_button();

        @if (empty($user->detailUser->bukti_mahasiswa) || empty($user->detailUser->bukti_kesanggupan))
            $('#lengkapiProfileModal').modal('show')

            upload('lengkapi_bukti_mahasiswa');
            upload('lengkapi_bukti_kesanggupan')
            $(document).on('click', '.btn--lengkapi-profile', function(e){
                e.preventDefault();

                data = {
                    bukti_kesanggupan: getUploadedFile['lengkapi_bukti_kesanggupan'],
                    bukti_mahasiswa: getUploadedFile['lengkapi_bukti_mahasiswa'],
                    alamat: $("textarea#lengkapi_alamat").val(),
                }
                console.log($("textarea#lengkapi_alamat").val());
                callApi("POST", "{{ route('api.lengkapi_profile') }}", data, function (req) {
                    pesan = req.message;
                    if (req.error == true) {
                        Swal.fire(
                        'Gagal melengkapi profile!',
                        pesan,
                        'error'
                        )
                    }else{
                        Swal.fire(
                        'Berhasil!',
                        pesan,
                        'success'
                        ).then((result) => {
                            $('.ff_fileupload_uploads').remove()
                            location.reload()
                        })
                    }
                })
            })
        @endif

      })

      $(document).on('click', '.btn-logout', function(e) {
        e.preventDefault();

        Swal.fire({
          title: 'Logout?',
          text: `Anda ingin melakukan logout!`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, logout!'
        }).then((result) => {
          if (result.isConfirmed) {

            callApi("POST", "{{ route('api.logout') }}", {}, function (req) {
                pesan = req.message;
                if (req.error == true) {
                    Swal.fire(
                        'Gagal melakukan logout!',
                        pesan,
                        'error'
                    )
                } else {
                    cookie.remove('token')
                    window.location.href = "{{ route('login') }}"
                }
            })

          }
        })
      });
    </script>

</body>

</html>
