<form action="{{ url('/pemasukan/import_ajax') }}" method="POST" id="form-import" enctype="multipart/form-data">
    @csrf
    <div id="myModal" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data pemasukan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Download Template</label>
                    <a href="{{ asset('template_pemasukan.xlsx') }}" class="btn btn-info btn-sm" download>
                        <i class="fa fa-file-excel"></i> Download
                    </a>
                </div>

                <div class="form-group">
                    <label>Pilih File</label>
                    <input type="file" name="file_pemasukan" id="file_pemasukan" class="form-control" required>
                    <small id="error-file_pemasukan" class="error-text form-text text-danger"></small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
            </div>
        </div>
    </div>
</form>


<script>
$(document).ready(function () {
    $("#form-import").on("submit", function (e) {
        e.preventDefault(); // agar tidak reload

        var form = $(this)[0];
        var formData = new FormData(form);

        $.ajax({
            url: $(form).attr("action"),
            type: form.method,
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $('.error-text').text('');
            },
            success: function (response) {
                if (response.status === true) {
                    $('#myModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message
                    });
                    $('#table-pemasukan').DataTable().ajax.reload();
                } else {
                    // tampilkan error validasi
                    $.each(response.msgField, function (key, value) {
                        $('#error-' + key).text(value[0]);
                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message
                    });
                }
            },
            error: function (xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error Server',
                    text: xhr.responseText
                });
            }
        });
    });
});
