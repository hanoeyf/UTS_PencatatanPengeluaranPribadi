<form action="{{ url('pemasukan/ajax') }}" method="POST" id="form-tambah-pemasukan"> 
    @csrf
    <div id="modal-pemasukan" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pemasukan</h5>
                <button type="button" class="close" data-dismiss ="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Pemasukan</label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                    <small id="error-nama" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control" required>
                    <small id="error-jumlah" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Asal Pemasukan</label>
                    <input type="text" name="asal" id="asal" class="form-control" required>
                    <small id="error-asal" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Tanggal Pemasukan</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                    <small id="error-tanggal" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        $("#form-tambah-pemasukan").validate({
            rules: {
                nama: { required: true, minlength: 3, maxlength: 255 },
                jumlah: { required: true, number: true },
                asal: { required: true, minlength: 3, maxlength: 100 },
                tanggal: { required: true, date: true }
            },
            submitHandler: function (form) {
            $('.error-text').text('');
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function (response) {
                    console.log(response); // pindahkan ke sini
                    if (response.status) {
                        $('#modal-pemasukan').modal('hide');  // Menutup modal setelah sukses
                        $('#form-tambah-pemasukan')[0].reset();  // Reset form untuk kosongkan input
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });
                        dataPemasukan.ajax.reload();
                    } else {
                        $('.error-text').text('');
                        $.each(response.msgField, function (prefix, val) {
                            $('#error-' + prefix).text(val[0]);
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: response.message
                        });
                    }
                }

            });
            return false;
        },

            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
