<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Simanika</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ url('assets/img/logo.png') }}" rel="icon">
    <link href="{{ url('assets/img/logo.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{url('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{url('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{url('assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
    <link href="{{url('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
    <link href="{{url('assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{url('assets/css/style.css')}}" rel="stylesheet">

    <!-- =======================================================
  * Template Name: Resi
  * Updated: Mar 10 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/resi-free-bootstrap-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top header-inner-pages">
        <div class="container d-flex align-items-center justify-content-between">

            <h1 class="logo"><a href="<?php echo url('/') ?>">SIMANIKA</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

        </div>
    </header><!-- End Header -->

    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <section id="breadcrumbs" class="breadcrumbs">
            <div class="container">

                <div class="d-flex justify-content-between align-items-center">
                    <ol>
                        <li><a href="<?php echo url('/') ?>">Home</a></li>
                        <li>Artikel</li>
                        <li><span class="judul-artikel"></span></li>
                    </ol>
                </div>

            </div>
        </section><!-- End Breadcrumbs -->

        <!-- ======= Tentang Kami Section ======= -->
        <section id="artikel" class="tentang-kami">
            <div class="container">

                <div class="row justify-content-center">
                    <div class="col-lg-12 pt-2">
                        <h1 class="judul-artikel"></h1>
                        <h6 class="penulis-artikel mb-4 bold"></h6>
                        <div class="col-12 mb-4">
                            <img src="<?php echo url('assets/img/loading2.gif') ?>" style="object-fit: scale-down" class="w-75 sampul-artikel rounded mx-auto d-block" height="400px" alt="Sampul Artikel">
                        </div>
                        <div class="col-12 konten-artikel" style="text-align: justify">
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fuga deleniti nesciunt adipisci reprehenderit sequi soluta! Mollitia incidunt beatae tempora laudantium vel! Blanditiis animi tempore libero id laudantium culpa minus consectetur!
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-12 mt-4">
                        <h3 class="mb-2">File Artikel:</h3>
                        <div id="carouselExampleControls" class="carousel carousel-dark slide" data-bs-ride="carousel">
                            <div class="carousel-inner file-artikel">

                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </section><!-- End tentang-kami Section -->

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">

        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="footer-contact">
                        <h3>SIMANIKA</h3>
                    </div>
                    <div class="col-lg-3 col-md-6 footer-newsleter">
                        <h4>alamat</h4>
                        <p>
                            Jl. Mastrip, Krajan Timur, Sumbersari, Kec. Sumbersari, Kabupaten Jember, Jawa Timur 68121.
                            Politeknik Negeri Jember
                        </p>
                    </div>



                    <div class="col-lg-4 col-md-6 footer-newsletter">
                        <h4>Kontak Kami</h4>
                        <p>Jika ada pesan, kesan, kritik dan saran atau ada artikel yang kurang layak dipublikasikan.
                            Silahkan hubungi kami melalui kontak atau email yang telah disediakan.</p>
                    </div>

                    <div class="col-lg-4 col-md-6 footer-newsletter">
                        <h4>Kontak</h4>
                        <p>
                            <strong>Instagram:</strong> @himanikapolije<br>
                            <strong>Email:</strong> himanikamif@gmail.com<br>
                            <strong>YouTube:</strong> Himanika Polije<br>
                        </p>
                    </div>

                </div>
            </div>
        </div>

        <div class="container d-md-flex py-4">

            <div class="me-md-auto text-center text-md-start">
                <div class="copyright">
                    &copy; Copyright <strong><span>SIMANIKA</span></strong>. All Rights Reserved
                </div>
                <div class="credits">
                    <!-- All the links in the footer should remain intact. -->
                    <!-- You can delete the links only if you purchased the pro version. -->
                    <!-- Licensing information: https://bootstrapmade.com/license/ -->
                    <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/resi-free-bootstrap-html-template/ -->
                    Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                </div>
            </div>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{url('assets/vendor/purecounter/purecounter_vanilla.js')}}"></script>
    <script src="{{url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{url('assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
    <script src="{{url('assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
    <script src="{{url('assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
    <script src="{{url('assets/vendor/php-email-form/validate.js')}}"></script>

    <!-- Template Main JS File -->
    <script src="{{url('assets/js/homepage-main.js')}}"></script>
    <script src="<?= url('assets/js/jquery-3.6.1.min.js') ?>"></script>
    <script src="<?= url('assets/js/dashboard-main.js') ?>"></script>

    <script>
		$(document).ready(function() {

			function getDetailArtikel() {
                let url = "{{ route('api.artikel.detail', ':id') }}";
                url = url.replace(':id', "{{ request()->segment(2) }}");
				callApi("GET", url, null, function(req) {
                    if(req.error == true) {
                        window.location.replace("{{ url('/') }}");
                    } else {
                        let data = req.data;
                        $('.judul-artikel').html(data.judul)
                        $('.konten-artikel').html(data.konten)
                        $('.penulis-artikel').html(data.penulis.nama+" - "+data.tanggal)
                        $('.sampul-artikel').attr('src', "{{ url('') }}"+data.sampul)

                        let html = '';

                        data.file.forEach(function(item, index) {
                            if (index == 0) {
                                html += `
                                    <div class="carousel-item active">
                                        <img src="{{ url('') }}${item}" style="object-fit: scale-down" class="d-block w-100" height="400px" alt="...">
                                    </div>
                                `;
                            } else {
                                html += `
                                    <div class="carousel-item">
                                        <img src="{{ url('') }}${item}" style="object-fit: scale-down" class="d-block w-100" height="400px" alt="...">
                                    </div>
                                `;
                            }
                        });

                        $('.file-artikel').html(html)

                        setDesign()
                    }
				}, function(xhr, status, error){
                    if (xhr.status === 404) {
                        // Kode untuk menangani respons 404 (Not Found) di sini
                        window.location.replace("{{ url('/') }}");
                    }
                })
			}

            function setDesign(){
                $('table').addClass('table')
                $('table').addClass('table-responsive')
                $('table').addClass('table-bordered')
            }

			getDetailArtikel()

		})
	</script>

</body>

</html>
