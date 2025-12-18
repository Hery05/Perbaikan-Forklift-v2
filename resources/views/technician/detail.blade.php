@extends('layouts.app')

@section('content')
<div class="container-fluid">

{{-- ================= INFO TUGAS ================= --}}
<div class="card shadow-sm mb-3">
    <div class="card-header bg-white">
        <h5 class="mb-0">
            <i class="fas fa-tools text-primary mr-1"></i>
            Detail Tugas Perbaikan
        </h5>
    </div>

    <div class="card-body">
        <div class="row mb-2">
            <div class="col-md-4"><strong>ID:</strong> #{{ $task->id }}</div>
            <div class="col-md-4">
                <strong>Status:</strong>
                <span class="badge
                    {{ $task->status=='DITUGASKAN' ? 'badge-warning' :
                       ($task->status=='SEDANG_DIKERJAKAN' ? 'badge-info' :
                       ($task->status=='MENUNGGU_SPAREPART' ? 'badge-secondary' :
                       ($task->status=='SPAREPART_TERSEDIA' ? 'badge-primary' : 
                       ($task->status=='SELESAI' ? 'badge-success' : 'badge-light')))) }}">
                    {{ $task->status }}
                </span>
            </div>
            <div class="col-md-4"><strong>Prioritas:</strong> {{ $task->prioritas ?? '-' }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <strong>Forklift:</strong>
                {{ $task->forklift->merk ?? '-' }} | {{ $task->forklift->tipe ?? '-' }}
            </div>
            <div class="col-md-4"><strong>Pelapor:</strong> {{ $task->user->name ?? '-' }}</div>
            <div class="col-md-4">
                <strong>Diajukan:</strong> {{ $task->created_at->format('d M Y H:i') }}
            </div>
        </div>

        <strong>Deskripsi Awal:</strong>
        <div class="border rounded p-2 bg-light">
            {{ $task->deskripsi_awal }}
        </div>
    </div>
</div>

{{-- ================= AKSI TEKNISI ================= --}}
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <strong>
            <i class="fas fa-cogs text-secondary mr-1"></i>
            Aksi Teknisi
        </strong>
    </div>

    <div class="card-body">

        {{-- ================= MULAI ================= --}}
        @if($task->status === 'DITUGASKAN')
        <form method="POST" action="/tasks/{{ $task->id }}/start">
            @csrf
            <button class="btn btn-primary">
                <i class="fas fa-play"></i> Mulai Perbaikan
            </button>
        </form>
        @endif

        {{-- ================= SEDANG DIKERJAKAN ================= --}}
       @if($task->status === 'SEDANG_DIKERJAKAN')
            <a href="{{ route('tasks.sparepart.form', $task->id) }}"
            class="btn btn-warning mb-2">
                <i class="fas fa-cogs"></i> Ajukan Sparepart
            </a>

            <button class="btn btn-success"
                    data-toggle="modal"
                    data-target="#finishModal">
                <i class="fas fa-check"></i> Selesaikan Perbaikan
            </button>
        @endif

        {{-- ================= MENUNGGU SPAREPART ================= --}}
        @if($task->status === 'MENUNGGU_SPAREPART')
        <div class="alert alert-warning mb-0">
            <i class="fas fa-clock"></i>
            Menunggu konfirmasi sparepart dari gudang
        </div>
        @endif

        {{-- ================= SPAREPART_TERSEDIA ================= --}}
        @if($task->status === 'SPAREPART_TERSEDIA')
            <button class="btn btn-success"
                    data-toggle="modal"
                    data-target="#finishModal1">
                <i class="fas fa-check"></i> Selesaikan Perbaikan
            </button>
        @endif

        {{-- ================= SELESAI ================= --}}
        @if($task->status === 'SELESAI')
        <div class="alert alert-success mb-0">
            <strong>Hasil Perbaikan:</strong><br>
            {{ $task->hasil_perbaikan }}
            <hr class="my-2">
            <strong>Durasi:</strong> {{ $task->durasi_menit }} menit
        </div>
        @endif

    </div>
</div>

{{-- ================= MODAL SELESAI SEDANG DIKERJAKAN ================= --}}
<div class="modal fade" id="finishModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="/tasks/{{ $task->id }}/finish">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-check"></i> Selesaikan Perbaikan
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Hasil Perbaikan</label>
                        <textarea name="hasil_perbaikan"
                                  class="form-control"
                                  required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Durasi (menit)</label>
                        <input type="number"
                               name="durasi_menit"
                               class="form-control"
                               min="1"
                               required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ================= MODAL SELESAI SPAREPART_TERSEDIA ================= --}}
<div class="modal fade" id="finishModal1" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="/tasks/{{ $task->id }}/finish1">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-check"></i> Selesaikan Perbaikan
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Hasil Perbaikan</label>
                        <textarea name="hasil_perbaikan"
                                  class="form-control"
                                  required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Durasi (menit)</label>
                        <input type="number"
                               name="durasi_menit"
                               class="form-control"
                               min="1"
                               required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
@endsection
