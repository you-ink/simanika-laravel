@push('script')
<script>
    $(document).ready(function () {

        sessionStorage.clear();

        function load_notification(params = []) {
            $("table.table").DataTable().destroy()
            $("table.table").DataTable({
                "deferRender": true,
                "responsive": true,
                'serverSide': true,
                'processing': true,
                "ordering": false,
                "ajax": {
                    "url": "{{ route('api.artikel.index') }}",
                    "type": "GET",
                    "data": {
                        "sort": "ASC"
                    },
                    "headers": {
                        "Authorization": getAuthorization()
                    },
                    "dataSrc": "data"
                },
                "columns": [
                    {
                        data: null,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1 + '.';
                        }
                    },
                    {
                        data: 'judul'
                    },
                    {
                        data: 'isi'
                    },
                    {
                        data: null,
                        render: res => {
                            let btn_edit = ''
                            let btn_delete = ''

                            btn_edit = `<button type="button" class="btn btn-sm mb-1 btn-primary btn-update-Notification" data-id="${res.id}" data-judul="${res.judul}" data-text="${res.konten}" data-toggle="modal" data-target="#crudModalArticle"><i class="fas fa-pen"></i></button>`


                            btn_delete =
                                `<button type="button" class="btn btn-sm mb-1 btn-danger btn-delete-Notification" data-id="${res.id}" data-judul="${res.judul}"><i class="fas fa-trash"></i></button>`


                            return `
                                        ${btn_edit}
                                        ${btn_delete}
                                    `;
                        }
                    }
                ],
            });
        }

        load_notification();

        $(document).on('click', '.btn-add-notification]', function () {
            $('.title-notification-modal').html('Tambah')
            $('.btn-confirm-add-notification').removeClass('d-none')
            $('.btn-confirm-update-notification').addClass('d-none')
            $('#crudModal notification-name').html('')

            $('#crudModal #notificationName').val('')
            $('#crudModal #notificationContent').val('')
        })

        $(document).on('click', '.btn-confirm-add-notification', function () {
            data = {
                nama: $("input#notificationName").val(),
                text: $("input#notificationContent").val(),
            }

            callApi("POST", "{{ route('api.notifikasi.store') }}", data, function (req) {
                pesan = req.message;
                if (req.error == true) {
                    Swal.fire(
                        'Gagal ditambahkan!',
                        pesan,
                        'error'
                    )
                } else {
                    Swal.fire(
                        'Ditambahkan!',
                        pesan,
                        'success'
                    )
                    $("#crudModal").modal("hide")
                    load_notification();
                    change_datatable_button();
                }
            })
        })

        $(document).on('click', ".btn-update-notification", function () {
            $('.title-notification-modal').html('Edit')
            $('.btn-confirm-update-notification').removeClass('d-none')
            $('.btn-confirm-add-notification').addClass('d-none')
            $('#crudModal .notification-name').html($(this).attr('data-name'))

            $('#crudModal #notificationName').val($(this).attr('data-name'))
            $('#crudModal #notificationContent').val($(this).attr('data-text'))

            $('.btn-confirm-update-notification').attr('data-id', $(this).attr('data-id'))
        })

        $(document).on('click', '.btn-confirm-update-notification', function () {
            data = {
                nama: $("input#notificationName").val(),
                text: $("input#notificationContent").val(),
            }

            let id = $(this).attr('data-id');

            let url = "{{ route('api.notifikasi.update', ':id') }}";
            url = url.replace(':id', id);

            callApi("PUT", url, data, function (req) {
                pesan = req.message;
                if (req.error == true) {
                    Swal.fire(
                        'Gagal diupdate!',
                        pesan,
                        'error'
                    )
                } else {
                    Swal.fire(
                        'Diupdate!',
                        pesan,
                        'success'
                    )
                    $("#crudModal").modal("hide")
                    load_notification();
                    change_datatable_button();
                }
            })
        })

        $(document).on('click', ".btn-delete-notification", function () {
            let id = $(this).attr('data-id')
            let name = $(this).attr('data-name')

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: `Anda ingin menghapus data ${name}!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = "{{ route('api.notifikasi.delete', ':id') }}";
                    url = url.replace(':id', id);
                    callApi("DELETE", url, [], function (req) {
                        pesan = req.message;
                        if (req.error == true) {
                            Swal.fire(
                                'Gagal Dihapus!',
                                pesan,
                                'error'
                            )
                        } else {
                            Swal.fire(
                                'Dihapus!',
                                pesan,
                                'success'
                            )
                            load_notification();
                            change_datatable_button();
                        }
                    })

                }
            })
        })

        $(document).on('click', '.btn-upload-file', function (e) {
            $('#crudModalDoc .document-article-name').html($(this).attr('data-name'))
            $('#crudModalDoc .btn--upload-file').attr('data-id', $(this).attr('data-id'))
        })

        // Upload Noteluensi
        upload('file')
        $(document).on('click', '#crudModalDocArticle .btn--upload-file', function (e) {
            console.log(getUploadedFile['file']);
            let data = {
                id: $(this).attr('data-id'),
                notulensi: getUploadedFile['file']
            }


        })

    })

</script>
@endpush