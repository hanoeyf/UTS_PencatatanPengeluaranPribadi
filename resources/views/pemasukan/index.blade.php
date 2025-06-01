@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/pemasukan/import') }}')" class="btn btn-info">Import Pemasukan</button>
                 <a href="{{ url('/pemasukan/export_excel') }}" class="btn btn-primary"><i class="fa fa-file- excel"></i> Export Pemasukan</a>
                <button onclick="modalAction('{{ url('/pemasukan/create_ajax') }}')" class="btn btn-sm btn-success mt-1">
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
                            <select class="form-control" id="asal" name="asal">
                                <option value="">- Semua -</option>
                                @foreach($asalList as $asal)
                                    <option value="{{ $asal }}">{{ $asal }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Asal Pemasukan</small>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-bordered table-striped table-hover table-sm" id="table_pemasukan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jumlah</th>
                        <th>Asal</th>
                        <th>Tanggal</th>
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

    var dataPemasukan;

    // Ketika dokumen siap, initialize DataTable dan konfigurasi filter
$(document).ready(function() {
    dataPemasukan = $('#table_pemasukan').DataTable({
        serverSide: true,
        ajax: {
            url: "{{ url('pemasukan/list') }}",
            type: "POST",
            data: function(d) {
                d.asal = $('#asal').val(); // Mengirimkan filter asal
                d._token = "{{ csrf_token() }}";
            },
            error: function(xhr, error, code) {
                alert('Error loading data: ' + error);
            }
        },
        columns: [
            { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
            { data: "nama" },
            { data: "jumlah" },
            { data: "asal" },
            { data: "tanggal" },
            { data: "aksi", orderable: false, searchable: false }
        ]
    });

    // Event ketika filter asal berubah
    $('#asal').on('change', function(){
        // Memastikan DataTable melakukan reload setelah filter berubah
        dataPemasukan.ajax.reload();
    });
});

</script>
@endpush
