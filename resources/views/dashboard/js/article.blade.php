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
                        data: null,
                        render: res => {
                            return `<img src="{{ url('/') }}${res.sampul}" alt="Foto ${res.judul}" width="125px" height="125px">`;
                        }
                    },
                    {
                        data: null,
                        render: res => {
                            return `${res.divisi.nama} ● ${res.penulis.nama}`;
                        }
                    },
                    {
                        data: "tanggal"
                    },
                    {
                        data: null,
                        render: res => {
                            let btn_deskripsi = ''

                            btn_deskripsi =
                                `<a href="{{ url('artikel') }}/${res.id}"><button type="button" class="btn btn-sm mb-1 btn-info" data-id="${res.id}" data-judul="${res.judul}"><i class="fas fa-info"></i> Deskripsi</button></a>`

                            return `
                                        ${btn_deskripsi}
                                    `;
                        }
                    },
                    {
                        data: null,
                        render: res => {
                            let btn_edit = ''
                            let btn_delete = ''

                            btn_edit = `<button type="button" class="btn btn-sm mb-1 btn-primary btn-update-article" data-id="${res.id}" data-judul="${res.judul}" data-konten="${$(res.konten).text()}" data-toggle="modal" data-target="#crudModal"><i class="fas fa-pen"></i></button>`


                            btn_delete =
                                `<button type="button" class="btn btn-sm mb-1 btn-danger btn-delete-article" data-id="${res.id}" data-judul="${res.judul}"><i class="fas fa-trash"></i></button>`


                            return `
                                        ${btn_edit}
                                        ${btn_delete}
                                    `;
                        }
                    }
                ],
            });
        }

        load_article();

        $(document).on('click', '.btn-add-article', function () {
            $('.title-article-modal').html('Tambah')
            $('.btn-confirm-add-article').removeClass('d-none')
            $('.btn-confirm-update-article').addClass('d-none')
            $('#crudModal article-name').html('')

            $('#crudModal #articleName').val('')
            $('#crudModal #articleContent').val('')
        })

        let articleContent;
        ClassicEditor
            .create( document.querySelector( '#articleContent' ) )
            .then( newArticleContent => {
                articleContent = newArticleContent;
            } )
            .catch( error => {
                console.error( error );
            });

        upload('cover')
        upload('files', 5)
        $(document).on('click', '.btn-confirm-add-article', function () {
            $(this).html("<i class='fas fa-spinner fa-pulse'></i>")
            $(this).attr('disabled', true)

            data = {
                judul: $("input#articleName").val(),
                konten: articleContent.getData(),
                sampul: getUploadedFile['cover'],
                file: getUploadedFile['files'],
            }

            callApi("POST", "{{ route('api.artikel.store') }}", data, function (req) {
                pesan = req.message;
                if (req.error == true) {
                    Swal.fire(
                        'Gagal ditambahkan!',
                        pesan,
                        'error'
                    ).then((result) => {
                        $('.btn-confirm-add-article').html("Tambah")
                        $('.btn-confirm-add-article').attr('disabled', false)
                    })
                } else {
                    Swal.fire(
                        'Ditambahkan!',
                        pesan,
                        'success'
                    ).then((result) => {
                        $('.btn-confirm-add-article').html("Set Tanggal")
                        $('.btn-confirm-add-article').attr('disabled', false)
                    })
                    $("#crudModal").modal("hide")
                    $('.ff_fileupload_uploads').remove()
                    load_article();
                    change_datatable_button();
                }
            })
        })

        $(document).on('click', ".btn-update-article", function () {
            $('.title-article-modal').html('Edit')
            $('.btn-confirm-update-article').removeClass('d-none')
            $('.btn-confirm-add-article').addClass('d-none')
            $('#crudModal .article-name').html($(this).attr('data-judul'))

            $('#crudModal #articleName').val($(this).attr('data-judul'))
            $('#crudModal #articleContent').val($(this).attr('data-konten'))

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

        $(document).on('click', ".btn-delete-article", function () {
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
                    let url = "{{ route('api.artikel.delete', ':id') }}";
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

    })

</script>
@endpush
