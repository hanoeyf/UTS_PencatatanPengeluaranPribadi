@extends('layouts.template')

@section('content')
<div class="card card-outline card-danger">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ url('pengeluaran') }}" class="form-horizontal">
            @csrf

            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Nama</label>
                <div class="col-11">
                    <input type="text" class="form-control" name="nama" value="{{ old('nama') }}" required>
                    @error('nama')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Jumlah</label>
                <div class="col-11">
                    <input type="number" class="form-control" name="jumlah" value="{{ old('jumlah') }}" required>
                    @error('jumlah')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Tujuan</label>
                <div class="col-11">
                    <input type="text" class="form-control" name="tujuan" value="{{ old('tujuan') }}" required>
                    @error('tujuan')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Kategori</label>
                <div class="col-11">
                    <input type="text" class="form-control" name="kategori" value="{{ old('kategori') }}" required>
                    @error('kategori')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Tanggal</label>
                <div class="col-11">
                    <input type="date" class="form-control" name="tanggal" value="{{ old('tanggal') }}" required>
                    @error('tanggal')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-1 control-label col-form-label"></label>
                <div class="col-11">
                    <button type="submit" class="btn btn-danger btn-sm">Simpan</button>
                    <a class="btn btn-sm btn-default ml-1" href="{{ url('pengeluaran') }}">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
