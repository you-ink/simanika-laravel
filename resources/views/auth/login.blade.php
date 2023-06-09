<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <title><--?php echo $title ?></title> -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- <title><--?php echo $title ?></title> -->
    <meta name="description" content="Official website Himpunan Mahasiswa Teknik Informatika (Himanika) POLIJE.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="<?php echo url('assets/img/logo2-himanika.png') ?>" type="image/icon type">


    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="<?= url('/assets/plugin/fontawesome/css/all.min.css') ?>" rel="stylesheet">
    <link href="<?= url('/assets/plugin/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">

</head>

<body>
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row" style="background-color:black;">
                            <div class="col-lg-5 d-none d-lg-block bg-login-image pt-5">
                                <div class="col-md-2">
                                    <img src="<?php echo url('assets/img/img/logo.png') ?>" alt="simanika">
                                </div>

                            </div>
                            <div class="col-lg-7" style="background-color:Black">
                                <div class="p-5">
                                    <div>
                                        <h1 class="h3 mb-0" style="color:white;"><span><b>Hello !</b></span></h1>
                                        <h1 class="h4 mb-4" style="color:DodgerBlue;"><span><b>Welcome To SIMANIKA
                                                    !</b></span></h1>
                                    </div>
                                    <hr color="white">
                                    <h1 class="h5 mb-4 text-center" style="color:white;"><span
                                            style="Color:DodgerBlue;"><b>Login </b></span>Your Account</h1>
                                    <form class="user" action="login.php" method="POST">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="txt_email"
                                                placeholder="email" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="txt_pass"
                                                placeholder="password" required>
                                        </div>
                                        <div>
                                            <input type="button" class="btn btn-primary btn-user btn-block btn-login" name="button"
                                                value="Login">
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div class="text-left col-6">
                                            <a class="small text-white mb-4"
                                                href="<?php echo url('/register') ?>">Create an Account!</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function get_api_url() {
            return "<?php echo url('api/') ?>";
        }

    </script>

    <script src="<?= url('assets/js/jquery-3.6.1.min.js') ?>"></script>
    <script src="<?= url('assets/plugin/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= url('assets/plugin/sweetalert2/sweetalert2.all.min.js') ?>"></script>
    <script src="<?= url('assets/js/jquery-cookie.min.js') ?>"></script>
    <script src="<?= url('assets/js/dashboard-main.js') ?>"></script>

    <script>
        $(document).on('click', '.btn-login', function (e) {
            e.preventDefault()

            data = {
                email: $("input#txt_email").val(),
                password: $("input#txt_pass").val()
            }

            callApi("POST", "{{ route('api.login') }}", data, function (req) {
                pesan = req.message;
                if (req.error == true) {
                    Swal.fire(
                        'Gagal!',
                        pesan,
                        'error'
                    )
                } else {
                    Swal.fire(
                        'Berhasil!',
                        pesan,
                        'success'
                    ).then((result) => {
                        cookie.set('token', req.data.token);
                        window.location.href = "<?php echo url('dashboard') ?>"
                    })
                }
            })
        })

    </script>
</body>

</html>
