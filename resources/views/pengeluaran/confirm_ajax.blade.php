@empty($pengeluaran)
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Kesalahan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5> 
                Data yang anda cari tidak ditemukan.
            </div>
            <a href="{{ url('/pengeluaran') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<div id="modal-master" class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header bg-danger text-white">
            <h5 class="modal-title">Konfirmasi Hapus</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Apakah kamu yakin ingin menghapus <strong>{{ $pengeluaran->nama }}</strong> dengan jumlah <strong>Rp {{ number_format($pengeluaran->jumlah, 0, ',', '.') }}</strong>?</p>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
            <button type="button" class="btn btn-danger" id="btn-confirm-delete" data-id="{{ $pengeluaran->id }}">Hapus</button>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#btn-confirm-delete').click(function() {
        var id = $(this).data('id');
        $.ajax({
            url: `/pengeluaran/${id}/delete_ajax`,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status) {
                    $('#myModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message
                    });
                    dataPengeluaran.ajax.reload(); // reload datatable
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.message
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat menghapus data.'
                });
            }
        });
    });
});
</script>
@endempty
