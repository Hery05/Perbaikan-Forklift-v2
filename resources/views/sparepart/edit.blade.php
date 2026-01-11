@extends('layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h3 class="card-title mb-0">
                <i class="fas fa-edit text-warning"></i>
                Edit Sparepart
            </h3>
        </div>

        <form method="POST" action="{{ route('sparepart.update', $sparepart->id) }}">
            @csrf
            @method('PUT')

            <div class="card-body">

                <div class="form-group">
                    <label>Kode Sparepart</label>
                    <input name="kode_sparepart" class="form-control" value="{{ $sparepart->kode_sparepart }}" required>
                </div>

                <div class="form-group">
                    <label>Nama Sparepart</label>
                    <input name="nama_sparepart" class="form-control" value="{{ $sparepart->nama_sparepart }}" required>
                </div>

                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="stok" class="form-control" min="0" value="{{ $sparepart->stok }}"
                        required>
                </div>

                <div class="form-group">
                    <label>Satuan</label>
                    <input name="satuan" class="form-control" value="{{ $sparepart->satuan }}" required>
                </div>

            </div>

            <div class="card-footer">
                <button class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('sparepart.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
