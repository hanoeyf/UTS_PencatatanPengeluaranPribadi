@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('pengeluaran/create') }}">Tambah</a>
                <button onclick="modalAction('{{ url('/pengeluaran/create_ajax') }}')" class="btn btn-sm btn-success mt-1">
                    Tambah Ajax
                </button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter :</label>
                        <div class="col-3">
                            <select class="form-control" id="kategori" name="kategori">
                                <option value="">- Semua -</option>
                                @foreach($kategoriList as $kategori)
                                    <option value="{{ $kategori }}">{{ $kategori }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Kategori Pengeluaran</small>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-bordered table-striped table-hover table-sm" id="table_pengeluaran">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jumlah</th>
                        <th>Tujuan</th>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>
@endsection

@push('js')
<script>
    // Fungsi untuk menampilkan modal dengan konten dari URL
    function modalAction(url='') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    var dataPengeluaran;

    // Fungsi untuk menghapus data pengeluaran menggunakan AJAX
    $(document).on('click', '.delete-pengeluaran', function() {
        var id = $(this).data('id');
        if (confirm("Apakah Anda yakin ingin menghapus pengeluaran ini?")) {
            $.ajax({
                url: '/pengeluaran/' + id + '/delete_ajax',
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert(response.success);
                    dataPengeluaran.ajax.reload();
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        }
    });

    // Ketika dokumen siap, initialize DataTable dan konfigurasi filter
    $(document).ready(function() {
        dataPengeluaran = $('#table_pengeluaran').DataTable({
            serverSide: true,
            ajax: {
                url: "{{ url('pengeluaran/list') }}",
                "dataType": "json",
                type: "POST",
                data: function (d) {
                    d.kategori = $('#kategori').val(); // Mengirimkan filter kategori
                },
            },
            columns: [
                { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                { data: "nama" },
                { data: "jumlah" },
                { data: "tujuan" },
                { data: "tanggal" },
                { data: "kategori" },
                { data: "aksi", orderable: false, searchable: false }
            ]
        });

        // Event ketika filter kategori berubah
        $('#kategori').on('change', function(){
            if ($.fn.DataTable.isDataTable('#table_pengeluaran')) {
                dataPengeluaran.ajax.reload();
            }
        });
    });
</script>
@endpush
