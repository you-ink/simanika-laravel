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
                    "url": "{{ route('api.notifikasi.index') }}",
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
                            var tanggal = new Date(res.created_at);
                            return tanggal.toLocaleString();
                        }
                    },
                ],
            });
        }

        load_notification();

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
    })

</script>
@endpush
