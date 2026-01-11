@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h3 class="card-title mb-0">
            <i class="fas fa-cogs text-primary"></i>
            Tambah Master Sparepart
        </h3>
    </div>

    <form method="POST" action="{{ route('sparepart.store') }}">
        @csrf

        <div class="card-body">

            <div class="form-group">
                <label>Kode Sparepart</label>
                <input name="kode_sparepart"
                       class="form-control"
                       placeholder="SP-001"
                       required>
            </div>

            <div class="form-group">
                <label>Nama Sparepart</label>
                <input name="nama_sparepart"
                       class="form-control"
                       placeholder="Oli Hidrolik"
                       required>
            </div>

            <div class="form-group">
                <label>Stok Awal</label>
                <input type="number"
                       name="stok"
                       class="form-control"
                       min="0"
                       value="0"
                       required>
            </div>

            <div class="form-group">
                <label>Satuan</label>
                <input name="satuan"
                       class="form-control"
                       placeholder="pcs / unit / liter"
                       required>
            </div>

        </div>

        <div class="card-footer">
            <button class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan
            </button>
            <a href="{{ route('sparepart.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
        </div>
    </form>
</div>
@endsection
