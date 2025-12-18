@extends('layouts.app')

@section('content')
<div class="card shadow-sm">

    {{-- HEADER --}}
    <div class="card-header">
        <i class="fas fa-file-alt text-primary"></i>
        Laporan Perbaikan Forklift

        @if(in_array(auth()->user()->role, ['admin', 'operator']))
            <a href="{{ url('/repair-requests/create') }}"
               class="btn btn-primary btn-sm float-right">
                <i class="fas fa-plus"></i>
                Ajukan Perbaikan
            </a>
        @endif
    </div>

    <div class="card-body">

        {{-- SEARCH --}}
        <div class="mb-3">
            <input type="text"
                   id="searchReport"
                   class="form-control form-control-sm"
                   placeholder="Cari pelapor / status / tanggal...">
        </div>

        {{-- TABLE --}}
        <div class="table-responsive">
        <table class="table table-bordered table-hover table-sm" id="reportTable">
            <thead class="bg-light">
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Pembuat</th>
                    <th>Forklift</th>
                    <th>Status</th>
                    <th width="70">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($repairs as $r)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $r->created_at->format('d-m-Y H:i') }}</td>
                    <td>{{ $r->user->name ?? '-' }}</td>

                    <td>
                        @if($r->forklift)
                            <span class="badge badge-light border">
                                <i class="fas fa-industry text-primary"></i>
                                {{ $r->forklift->kode_forklift }}
                                <small class="text-muted">
                                    ({{ $r->forklift->merk }} {{ $r->forklift->tipe }})
                                </small>
                            </span>
                        @else
                            -
                        @endif
                    </td>

                    <td>
                        @php
                            $badge = match($r->status) {
                                'DIAJUKAN'            => 'secondary',
                                'DITUGASKAN'          => 'warning',
                                'SEDANG_DIKERJAKAN'   => 'info',
                                'MENUNGGU_SPAREPART'  => 'dark',
                                'SELESAI'             => 'success',
                                default               => 'light'
                            };
                        @endphp
                        <span class="badge badge-{{ $badge }}">
                            {{ $r->status }}
                        </span>
                    </td>

                    <td class="text-center">
                        @if($r->status === 'SELESAI')
                            <button class="btn btn-sm btn-info"
                                    data-toggle="modal"
                                    data-target="#detailModal{{ $r->id }}">
                                <i class="fas fa-eye"></i>
                            </button>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-2">
            {{ $repairs->links() }}
        </div>

    </div>
</div>

{{-- ================= MODAL DETAIL (DI LUAR TABLE) ================= --}}
@foreach($repairs as $r)
@if($r->status === 'SELESAI')
<div class="modal fade" id="detailModal{{ $r->id }}" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title">
                <i class="fas fa-clipboard-check"></i>
                Detail Hasil Perbaikan
            </h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
            <table class="table table-sm table-bordered">
                <tr>
                    <th width="30%">Forklift</th>
                    <td>
                        {{ $r->forklift->kode_forklift ?? '-' }}
                        ({{ $r->forklift->merk ?? '-' }} {{ $r->forklift->tipe ?? '-' }})
                    </td>
                </tr>
                <tr>
                    <th>Teknisi</th>
                    <td>{{ $r->technician->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Deskripsi Awal</th>
                    <td class="bg-light">
                        {{ $r->deskripsi_awal }}
                    </td>
                </tr>
                <tr>
                    <th>Durasi</th>
                    <td><strong>{{ $r->durasi_menit }} menit</strong></td>
                </tr>
                <tr>
                    <th>Hasil Perbaikan</th>
                    <td class="bg-light">{{ $r->hasil_perbaikan }}</td>
                </tr>
            </table>
        </div>

        <div class="modal-footer">
            <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>

    </div>
  </div>
</div>
@endif
@endforeach

@endsection

{{-- ================= SEARCH SCRIPT ================= --}}
@section('scripts')
<script>
document.getElementById('searchReport').addEventListener('keyup', function () {
    let value = this.value.toLowerCase();
    document.querySelectorAll('#reportTable tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value)
            ? ''
            : 'none';
    });
});
</script>
@endsection
