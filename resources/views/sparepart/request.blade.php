@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h3 class="card-title mb-0">
                <i class='fas fa-list text-primary'></i>
                Permintaan Sparepart dari Teknisi</h3>
        </div>

        <div class="card-body">
            
            <form method="GET" action="{{ route('sparepart.request') }}" class="mb-3 position-relative">
                <div class="input-group">
                    <input type="text" name="q" value="{{ $keyword ?? '' }}" class="form-control" placeholder="Cari sparepart / forklift / teknisi..." autocomplete="off">
                    <div class="input-group-append">
                        <button class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Teknisi</th>
                            <th>Forklift</th>
                            <th>Sparepart</th>
                            <th>Qty</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Tanggal Request</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $req)
                            @php
                                $sparepartStok = $req->sparepart->stok ?? 0;
                                $stokCukup = $sparepartStok >= $req->jumlah;
                                $rowClass = $stokCukup ? '' : 'table-warning';
                                $statusBadge = match($req->status) {
                                    'DIPROSES' => 'warning',
                                    'DISETUJUI' => 'success',
                                    'DITOLAK' => 'danger',
                                    'SPAREPART_TERSEDIA' => 'info',
                                    'TERSEDIA' => 'success',
                                    default => 'secondary'
                                };
                            @endphp
                            <tr class="{{ $rowClass }}">
                                <td>{{ $loop->iteration + ($requests->currentPage()-1)*$requests->perPage() }}</td>
                                <td>{{ $req->repairRequest->technician->name ?? '-' }}</td>
                                <td>{{ $req->repairRequest->forklift->kode_forklift ?? '-' }}</td>
                                <td>{{ $req->sparepart->nama_sparepart ?? '-' }}</td>
                                <td>{{ $req->jumlah }}</td>
                                <td>
                                    <span class="badge badge-{{ $stokCukup ? 'success' : 'danger' }}">
                                        {{ $sparepartStok }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $statusBadge }}">{{ $req->status }}</span>
                                </td>
                                <td>{{ $req->created_at->format('d-m-Y H:i') }}</td>
                                <td>
                                    @if($req->status == 'DIPROSES')
                                        <div class="d-flex justify-content-center">
                                            <form action="{{ route('spareparts.updateStatus', [$req->id, 'DISETUJUI']) }}" method="POST" class="mr-1">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" {{ !$stokCukup ? 'disabled' : '' }} title="{{ $stokCukup ? 'Setujui permintaan' : 'Stok kurang' }}">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('spareparts.updateStatus', [$req->id, 'DITOLAK']) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger" title="Tolak permintaan">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-3">Belum ada permintaan sparepart</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-end">
            {{ $requests->links() }}
        </div>
    </div>
</div>

{{-- Tambahan CSS --}}
<style>
    .table td, .table th {
        vertical-align: middle;
    }
    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }
    .badge {
        font-size: 90%;
        padding: 0.4em 0.7em;
    }
</style>
@endsection
