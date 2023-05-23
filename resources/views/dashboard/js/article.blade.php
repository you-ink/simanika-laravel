@extends('app.template')
@push('script')
<script>
    $(document).ready(function () {

        sessionStorage.clear();

        function load_article(params = []) {
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
                "columns": [{
                        data: null,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1 + '.';
                        }
                    },
                    {
                        data: 'judul'
                    },
                    {
                        data: 'konten'
                    }, 
                    {
                        data: 'sampul'
                    }, 
                    {
                        data: null,
                        render: res => {
                            let button = ''
                            let file = ''
                            if (res.file) {
                                file =
                                    `<p class="my-1"><a href="{{ url('/') }}${res.file}" taget="_blank" class="text-primary">Lihat file</a></p>`
                            } else {
                                file = '<p class="my-1">-</p>'
                            }

                            button =
                                `<button type="button" class="btn btn-sm btn-secondary btn-upload-document" data-id="${res.id}" data-name="${res.file}" data-toggle="modal" data-target="#crudModalDocArticle" ><i class="fas fa-upload"></i></button>`


                            return `
                                    ${button}${file}
                                `;
                        }
                    }, 
                    {
                        data: null,
                        render: res => {
                            let btn_edit = ''
                            let btn_delete = ''

                            btn_edit =
                                `<button type="button" class="btn btn-sm mb-1 btn-primary btn-update-Article" data-id="${res.id}" data-name="${res.judul}" data-text="${res.deskripsi_konten}" data-toggle="modal" data-target="#crudModalArticle"><i class="fas fa-pen"></i></button>`


                            btn_delete =
                                `<button type="button" class="btn btn-sm mb-1 btn-danger btn-delete-Article" data-id="${res.id}" data-name="${res.nama}"><i class="fas fa-trash"></i></button>`


                            return `
                                        ${btn_edit}
                                        ${btn_delete}
                                    `;
                        }
                    }
                ],
                

        load_article();

        $(document).on('click', '.btn-add-article', function () {
            $('.title-article-modal').html('Tambah')
            $('.btn-confirm-add-article').removeClass('d-none')
            $('.btn-confirm-update-article').addClass('d-none')
            $('#crudModal article-name').html('')

            $('#crudModal #articleName').val('')
            $('#crudModal #articleContent').val('')
        })

        $(document).on('click', '.btn-confirm-add-artcle', function () {
            data = {
                nama: $("input#articleName").val(),
                text: $("input#articleContent").val(),
            }

            callApi("POST", "{{ route('api.artikel.store') }}", data, function (req) {
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
                    load_article();
                    change_datatable_button();
                }
            })
        })

        $(document).on('click', ".btn-update-article", function () {
            $('.title-article-modal').html('Edit')
            $('.btn-confirm-update-article').removeClass('d-none')
            $('.btn-confirm-add-article').addClass('d-none')
            $('#crudModal .article-name').html($(this).attr('data-name'))

            $('#crudModal #articleName').val($(this).attr('data-name'))
            $('#crudModal #articleContent').val($(this).attr('data-text'))

            $('.btn-confirm-update-article').attr('data-id', $(this).attr('data-id'))
        })

        $(document).on('click', '.btn-confirm-update-article', function () {
            data = {
                nama: $("input#articleName").val(),
                text: $("input#articleContent").val(),
            }

            let id = $(this).attr('data-id');

            let url = "{{ route('api.artikel.update', ':id') }}";
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
                    load_artikel();
                    change_datatable_button();
                }
            })
        })

        $(document).on('click', ".btn-delete-meeting", function () {
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
                    let url = "{{ route('api.rapat.delete', ':id') }}";
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
                            load_article();
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
        $(document).on('click', '#crudModalDoc .btn--upload-file', function (e) {
            console.log(getUploadedFile['file']);
            let data = {
                id: $(this).attr('data-id'),
                notulensi: getUploadedFile['file']
            }

            callApi("POST", "{{ route('api.artikel.upload_file') }}", data, function (req) {
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
                    ).then((result) => {
                        $('#crudModalDoc').remove()
                        window.location.reload()
                    })

                    load_article();
                    change_datatable_button();
                }
            })
        })

    })

</script>
@endpush