@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">
            <h3 class="card-title">
            <i class="fas fa-edit text-primary"></i>
            Edit Sparepart
            </h3>
    </div>

    <form method="POST" action="{{ route('spareparts.update', $sparepart->id) }}">
        @csrf
        @method('PUT')

        <div class="card-body">

            <div class="form-group">
                <label>Kode Sparepart</label>
                <input name="kode" class="form-control"
                       value="{{ $sparepart->kode }}" required>
            </div>

            <div class="form-group">
                <label>Nama Sparepart</label>
                <input name="nama" class="form-control"
                       value="{{ $sparepart->nama }}" required>
            </div>

            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stok" class="form-control"
                       value="{{ $sparepart->stok }}" min="0" required>
            </div>

            <div class="form-group">
                <label>Satuan</label>
                <input name="satuan" class="form-control"
                       value="{{ $sparepart->satuan }}" required>
            </div>

            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control">{{ $sparepart->keterangan }}</textarea>
            </div>

        </div>

        <div class="card-footer">
            <button class="btn btn-primary">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('spareparts.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection
