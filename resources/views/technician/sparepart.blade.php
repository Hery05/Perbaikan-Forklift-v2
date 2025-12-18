@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <strong>Permintaan Sparepart</strong>
    </div>

    <div class="card-body">
        <form method="POST"
              action="{{ route('tasks.sparepart.store', $task->id) }}">
            @csrf

            <div class="form-group">
                <label>Nama Sparepart</label>
                <input type="text" name="nama_sparepart"
                       class="form-control" required>
            </div>

            <div class="form-group">
                <label>Jumlah</label>
                <input type="number" name="jumlah"
                       class="form-control" min="1" required>
            </div>

            <button class="btn btn-warning">
                <i class="fas fa-paper-plane"></i> Kirim Permintaan
            </button>

            <a href="{{ url()->previous() }}"
               class="btn btn-secondary">
               Batal
            </a>
        </form>
    </div>
</div>
@endsection
