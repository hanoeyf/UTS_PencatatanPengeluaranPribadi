<form action="{{ url('pengeluaran/ajax') }}" method="POST" id="form-tambah-pengeluaran">
    @csrf
    <div id="modal-pengeluaran" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Pengeluaran</h5>
                <button type="button" class="close" data-dismiss ="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Pengeluaran</label>
                    <input type="text" name="nama" id="nama_pengeluaran" class="form-control" required>
                    <small id="error-nama_pengeluaran" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah_pengeluaran" class="form-control" required>
                    <small id="error-jumlah_pengeluaran" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <input type="text" name="tujuan" id="tujuan" class="form-control" required>
                    <small id="error-tujuan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Kategori</label>
                    <input type="text" name="kategori" id="kategori" class="form-control" required>
                    <small id="error-kategori" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal_pengeluaran" class="form-control" required>
                    <small id="error-tanggal_pengeluaran" class="error-text form-text text-danger"></small>
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
    $("#form-tambah-pengeluaran").validate({
        rules: {
            nama: { required: true, minlength: 3, maxlength: 255 },
            jumlah: { required: true, number: true },
            tujuan: { required: true, minlength: 3 },
            kategori: { required: true, minlength: 3 },
            tanggal: { required: true, date: true }
        },

        submitHandler: function (form) {
            $('.error-text').text('');

            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function (response) {
                    if (response.status) {
                        $('#modal-pengeluaran').modal('hide');
                        $('#form-tambah-pengeluaran')[0].reset();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });
                        dataPengeluaran.ajax.reload(); // reload datatable
                    } else {
                        $('.error-text').text('');
                        $.each(response.msgField, function (prefix, val) {
                            $('#error-' + prefix).text(val[0]);
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
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
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        }
    });
});
</script>
