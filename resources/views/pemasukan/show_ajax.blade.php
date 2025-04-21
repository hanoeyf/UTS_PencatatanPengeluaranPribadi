<!-- resources/views/pemasukan/detail_ajax.blade.php -->
<div class="modal-header">
    <h5 class="modal-title">Detail Pemasukan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    @empty(!$pemasukan)
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
            Data yang Anda cari tidak ditemukan.
        </div>
    @else
        <table class="table table-bordered table-striped">
            <tr>
                <th>ID</th>
                <td>{{ $pemasukan->id }}</td>
            </tr>
            <tr>
                <th>Nama</th>
                <td>{{ $pemasukan->nama }}</td>
            </tr>
            <tr>
                <th>Jumlah</th>
                <td>{{ number_format($pemasukan->jumlah, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Asal</th>
                <td>{{ $pemasukan->asal }}</td>
            </tr>
            <tr>
                <th>Tanggal</th>
                <td>{{ \Carbon\Carbon::parse($pemasukan->tanggal)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <th>Dibuat Pada</th>
                <td>{{ $pemasukan->created_at->format('d-m-Y H:i:s') }}</td>
            </tr>
            <tr>
                <th>Diperbarui Pada</th>
                <td>{{ $pemasukan->updated_at->format('d-m-Y H:i:s') }}</td>
            </tr>
        </table>
    @endempty
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
</div>
<script>
    $(document).ready(function() {
        // Initialize the modal
        $('#myModal').modal('show');
    });

</script>