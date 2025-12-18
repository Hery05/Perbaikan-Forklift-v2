@extends('layouts.app')

@section('content')
<div class="card shadow-sm">

    <div class="card-header bg-white">
        <h5 class="mb-0">
            <i class="fas fa-plus-circle text-success mr-1"></i>
            Ajukan Permintaan Perbaikan Forklift
        </h5>
    </div>

    <form method="POST" action="{{ url('/repair-requests') }}">
        @csrf

        <div class="card-body">

            {{-- PILIH FORKLIFT --}}
            <div class="form-group">
                <label>
                    <i class="fas fa-industry text-primary mr-1"></i>
                    Unit Forklift
                </label>

                <select name="forklift_id"
                        class="form-control @error('forklift_id') is-invalid @enderror">
                    <option value="">-- Pilih Forklift --</option>

                    @foreach($forklifts as $f)
                        <option value="{{ $f->id }}"
                            {{ old('forklift_id') == $f->id ? 'selected' : '' }}>
                            {{ $f->merk }} - {{ $f->tipe }}
                        </option>
                    @endforeach
                </select>

                @error('forklift_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            {{-- DESKRIPSI --}}
            <div class="form-group">
                <label>
                    <i class="fas fa-tools text-secondary mr-1"></i>
                    Deskripsi Masalah
                </label>

                <textarea
                    name="deskripsi_awal"
                    rows="4"
                    class="form-control @error('deskripsi_awal') is-invalid @enderror"
                    placeholder="Contoh: Forklift tidak bisa dihidupkan, terdengar bunyi aneh pada mesin..."
                >{{ old('deskripsi_awal') }}</textarea>

                @error('deskripsi_awal')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

        </div>

        <div class="card-footer bg-white text-right">
            <a href="{{ url('/reports/repairs') }}" class="btn btn-light">
                <i class="fas fa-arrow-left"></i> Lihat Progress Perbaikan
            </a>

            <button type="submit" class="btn btn-success">
                <i class="fas fa-paper-plane"></i> Kirim Permintaan
            </button>
        </div>

    </form>

</div>
@endsection
