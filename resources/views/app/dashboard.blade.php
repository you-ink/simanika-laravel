<!doctype html>
<html class="no-js h-100" lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Dashboard - @yield('title')</title>
    <meta name="description" content="Official website Himpunan Mahasiswa Teknik Informatika (Himanika) POLIJE.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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

                        <li class="nav-item">
                            <a class="nav-link <?php echo (request()->segment(2) == 'meeting')?'active':'' ?>"
                                href="<?php echo url('dashboard/meeting') ?>">
                                <i class="material-icons">groups</i>
                                <span>Rapat</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo (request()->segment(2) == 'division')?'active':'' ?>"
                                href="<?php echo url('dashboard/artikel') ?>">
                                <i class="material-icons">toc</i>
                                <span>Artikel</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo (request()->segment(2) == 'program')?'active':'' ?>"
                                href="<?php echo url('dashboard/work_program') ?>">
                                <i class="material-icons">analytics</i>
                                <span>Program Kerja</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?php echo (request()->segment(2) == 'division')?'active':'' ?>"
                                href="<?php echo url('dashboard/division') ?>">
                                <i class="material-icons">toc</i>
                                <span>Data Divisi</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo (request()->segment(2) == 'position')?'active':'' ?>"
                                href="<?php echo url('dashboard/position') ?>">
                                <i class="material-icons">toc</i>
                                <span>Data Jabatan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo (request()->segment(2) == 'member')?'active':'' ?>"
                                href="<?php echo url('dashboard/member') ?>">
                                <i class="material-icons">table_chart</i>
                                <span>Data Anggota</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?php echo (request()->segment(2) == 'profile')?'active':'' ?>"
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
                                        <span class="badge badge-pill badge-danger">2</span>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-small" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="#">
                                        <div class="notification__icon-wrapper">
                                            <div class="notification__icon">
                                                <i class="material-icons">&#xE6E1;</i>
                                            </div>
                                        </div>
                                        <div class="notification__content">
                                            <span class="notification__category">Rapat Proker</span>
                                            <p>Rapat Disnat ke 3</p>
                                                <p><span class="text-danger text-semibold">12/06/2023</span></p>
                                        </div>
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <div class="notification__icon-wrapper">
                                            <div class="notification__icon">
                                                <i class="material-icons">&#xE8D1;</i>
                                            </div>
                                        </div>
                                        <div class="notification__content">
                                            <span class="notification__category">Rapat Resmi</span>
                                            <p>Rapat Penerimaan anggota baru</p>
                                                <p> <span class="text-success text-semibold">12/05/2023</span></p>
                                        </div>
                                    </a>
                                    <a class="dropdown-item notification__all text-center"  href="<?php echo url('dashboard/notifikasi') ?>"> View all
                                        Notifications </a>
                                </div>
                            </li>



                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#"
                                    role="button" aria-haspopup="true" aria-expanded="false">
                                    <img class="user-avatar rounded-circle mr-2"
                                        src="<?php echo url('assets/img/user.png')?>" alt="User Avatar"
                                        style="width: 2.5rem !important; height: 2.5rem !important;">
                                    <span class="d-none d-md-inline-block"><?php echo "budi" ?></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-small">
                                    <a class="dropdown-item" href="<?php echo url('dashboard/profile') ?>">
                                        <i class="material-icons">&#xE7FD;</i> Profile
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger btn-logout" href="<?php echo url('/login') ?>">
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

                <footer class="main-footer d-flex p-2 px-3 bg-white border-top">
                    <span class="copyright ml-auto my-auto mr-2">Copyright &copy; 2023
                        <a href="<?php echo url('home/') ?>" rel="nofollow">Simanika</a>
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
    <script src="<?= url('assets/js/dashboard-main.js') ?>"></script>



    @stack('script') {{-- Pemanggilan -> @push --}}


</body>

</html>
