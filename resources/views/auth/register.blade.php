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

    <link href="<?= url('/assets/plugin/fontawesome/css/all.min.css') ?>" rel="stylesheet">
    <link href="<?= url('/assets/plugin/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= url('/assets/plugin/fancy-file-uploader/fancy_fileupload.css') ?>" rel="stylesheet">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style type="text/css">
        .ff_fileupload_filename {
            max-width: 280px !important;
        }

    </style>

</head>

<body>
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0" style="background-color:Black;">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-5 d-none d-lg-block h-100 bg-login-image" style="vertical-align: center">
                                <div class="col-12 pt-5">
                                    <img src="<?php echo url('assets/img/img/logo.png') ?>" alt="simanika"
                                        style="width:400px;height:400px;">
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h3 mb-0" style="color:white;"><span><b>REGISTER</b></span></h1>
                                        <hr class="text-white bg-info">
                                        <h6 class="text-white mb-4">Thank You for joining us. Please
                                            register by completing the information below. </h6>
                                    </div>
                                    <!-- <div class="text">
										<h1 class="h3 mb-4" style="color:white;"><span>REGISTER</h1>
										<h6 class="h6 mb-4" style="color:white;">Thank You for joining us. Please
											register by completing the information below. </h6> <br> -->
                                    <form style="max-height: 450px !important; overflow-x: hidden;"
                                        class="p-2">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="fefulltName" style="color:white;">Nama Lengkap</label>
                                                <input type="text" class="form-control" id="nama"
                                                    placeholder="Nama lengkap"> </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="feEmailAddress" style="color:white;">Email</label>
                                                <input type="email" class="form-control" id="email" placeholder="Email">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="fePassword" style="color:white;">NIM</label>
                                                <input type="text" class="form-control" id="nim" placeholder="NIM">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="feAngkatan" style="color:white;">Angkatan</label>
                                                <input type="text" class="form-control" id="angkatan"
                                                    placeholder="Angkatan">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="feNoHp" style="color:white;">NO HP</label>
                                                <input type="text" class="form-control" id="telp"
                                                    placeholder="Nomer Hanphone">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="feEmailAddress" style="color:white;">Password</label>
                                                <input type="password" class="form-control" id="password"
                                                    placeholder="Password"> </div>
                                            <div class="form-group col-md-6">
                                                <label for="fePassword" style="color:white;">Konfirmasi Password</label>
                                                <input type="password" class="form-control" id="confirm_password"
                                                    placeholder="Konfirmasi Password"> </div>
                                        </div>
                                        <div class="form-row mt-3">
                                            <div class="form-group col-md-12">
                                                <input type="submit" name="register"
                                                    class="btn btn-block btn-primary btn-register" value="Register">
                                            </div>
                                        </div>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="<?php echo url('/login') ?>" style="color:white;">Already
                                            have an account? Login!</a>
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
    <script src="<?= url('assets/plugin/fancy-file-uploader/jquery.ui.widget.js') ?>"></script>
    <script src="<?= url('assets/plugin/fancy-file-uploader/jquery.fileupload.js') ?>"></script>
    <script src="<?= url('assets/plugin/fancy-file-uploader/jquery.iframe-transport.js') ?>"></script>
    <script src="<?= url('assets/plugin/fancy-file-uploader/jquery.fancy-fileupload.js') ?>"></script>
    <script src="<?= url('assets/js/dashboard-main.js') ?>"></script>

    <script>
        $(document).ready(function () {

            $(document).on('click', '.btn-register', function (e) {
                e.preventDefault()

                data = {
                    nama: $("input#nama").val(),
                    email: $("input#email").val(),
                    nim: $("input#nim").val(),
                    angkatan: $("input#angkatan").val(),
                    telp: $("input#telp").val(),
                    password: $("input#password").val(),
                    password_confirmation: $("input#confirm_password").val(),
                }

                callApi("POST", "{{ route('api.register') }}", data, function (req) {
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
                            window.location.href = "<?php echo route('login') ?>"
                        })
                    }
                })
            })
        })

    </script>

    <script>
        // Function For Upload File
        function upload(name, maxFiles = 1) {
            $(`#${name}`).FancyFileUpload({
                params: {
                    action: 'fileuploader'
                },
                edit: false,
                maxfilesize: 10000000,
                added: function (e, data) {
                    if (data.ff_info.errors.length > 0) {
                        Swal.fire(
                            'Gagal Ditambahkan!',
                            'Error: ' + data.ff_info.errors,
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

                    // Get Base64 of File & Set Session To Save The Data
                    getBase64(data.files[0], name)

                    $(this).find('.ff_fileupload_start_upload').remove()
                }
            });
        }

        $(document).on('click', '.ff_fileupload_remove_file', function (e) {
            let doc = $(this).attr('data-doc')
            if ($(`.upload--${doc}`).find('.ff_fileupload_queued').length < 1) {
                $(`.upload--${doc}`).find('.btn--upload-file').addClass('d-none');
            }
        });

    </script>

</body>

</html>
