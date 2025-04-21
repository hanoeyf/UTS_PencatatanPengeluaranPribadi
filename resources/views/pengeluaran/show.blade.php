@extends('layouts.template')

@section('content')
<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>

    <div class="card-body">
        @empty($pengeluaran)
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                Data yang Anda cari tidak ditemukan.
            </div>
        @else
            <table class="table table-bordered table-striped table-hover table-sm">
                <tr>
                    <th>ID</th>
                    <td>{{ $pengeluaran->id }}</td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <td>{{ $pengeluaran->nama }}</td>
                </tr>
                <tr>
                    <th>Jumlah</th>
                    <td>{{ number_format($pengeluaran->jumlah, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Tujuan</th>
                    <td>{{ $pengeluaran->tujuan }}</td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td>{{ $pengeluaran->kategori }}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>{{ \Carbon\Carbon::parse($pengeluaran->tanggal)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <th>Dibuat Pada</th>
                    <td>{{ $pengeluaran->created_at->format('d-m-Y H:i:s') }}</td>
                </tr>
                <tr>
                    <th>Diperbarui Pada</th>
                    <td>{{ $pengeluaran->updated_at->format('d-m-Y H:i:s') }}</td>
                </tr>
            </table>
        @endempty

        <a href="{{ url('pengeluaran') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
