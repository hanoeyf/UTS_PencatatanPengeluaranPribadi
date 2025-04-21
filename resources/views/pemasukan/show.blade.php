@extends('layouts.template')

@section('content')
<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>

    <div class="card-body">
        @empty($pemasukan)
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                Data yang Anda cari tidak ditemukan.
            </div>
        @else
            <table class="table table-bordered table-striped table-hover table-sm">
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

        <a href="{{ url('pemasukan') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
    </div>
</div>
@endsection

@push('css')
@endpush
@push('js')
@endpush
