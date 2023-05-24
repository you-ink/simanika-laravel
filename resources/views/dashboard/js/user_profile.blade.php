@push('script')
<script>
	$(document).ready(function() {

		upload('foto');
		$(document).on('click', '.btn-update-profile', function (e) {
			e.preventDefault()

			data = {
				nama: $("input#nama").val(),
				angkatan: $("input#angkatan").val(),
				telp: $("input#telp").val(),
				alamat: $("textarea#alamat").text(),
			}


            if (getUploadedFile['foto']) {
                data.foto = getUploadedFile['foto'];
            }

			callApi("POST", "{{ route('api.user.edit_profile') }}", data, function (req) {
				pesan = req.message;
				if (req.error == true) {
					Swal.fire(
				      'Gagal diupdate!',
				      pesan,
				      'error'
				    )
				}else{
					Swal.fire(
				      'Diupdate!',
				      pesan,
				      'success'
				    ).then((result) => {
                        $('.ff_fileupload_uploads').remove()
				    	location.reload()
					})
				}
			})
		})

	})
</script>
@endpush
