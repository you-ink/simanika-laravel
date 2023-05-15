@push('script')
    <script>
        $(document).ready(function () {

            function load_presensi(params = []) {
                let url = "{{ route('api.rapat.detail', ':id') }}";
                url = url.replace(':id', "{{ request()->segment(3) }}");
                callApi("GET", url, [], function (req) {
                    let data = req.data;
                    $("#meeting-name").html(data.nama)

                    let presensiData = data.presensi;

                    $("table.table").DataTable().destroy()
                    $("table.table").DataTable({
                        "deferRender": true,
                        "responsive": true,
                        'serverSide': false,
                        'processing': false,
                        "ordering": false,
                        "data": presensiData,
                        "columns": [
                            {
                                data: null,
                                render: function (data, type, row, meta) {
                                    return meta.row + meta.settings._iDisplayStart + 1 + '.';
                                }
                            },
                            {
                                data: null,
                                render: res => {
                                    return `${res.detail_user.nama}`;
                                }
                            },
                            {
                                data: null,
                                render: res => {
                                    return `<img src="{{ url('/') }}${res.foto}" alt="Foto ${res.detail_user.nama}" width="125px" height="125px">`;
                                }
                            },
                            {
                                data: 'peran'
                            },
                            {
                                data: 'waktu_hadir'
                            },
                        ],
                        dom: "<'row'<'col-sm-12 mb-2'B>>lfrtip",
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                        buttons: [
                            {
                                extend: 'excel',
                                text: '<i class="fas fa-download"></i> Download Excel',
                                filename: 'Data Presensi '+data.nama,
                                title: null,
                                className: 'btn btn-sm btn-success',
                                exportOptions: {
                                    columns: [ 0, 1, 3, 4 ]
                                }
                            },
                            {
                                extend: 'print',
                                text: '<i class="fas fa-print"></i> Print',
                                title: 'Data Presensi '+data.nama,
                                className: 'btn btn-sm btn-success',
                                exportOptions: {
                                    columns: [ 0, 1, 3, 4 ]
                                }
                            },
                        ]
                    });

                    change_datatable_button();
                });
            }

            load_presensi();

        })

    </script>
@endpush
