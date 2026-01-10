@extends('layouts.app')

@section('content')
    <div class="card shadow-sm">

        {{-- HEADER --}}
        <div class="card-header">
            <i class="fas fa-file-alt text-primary"></i>
            Laporan Perbaikan Forklift

            @if (in_array(auth()->user()->role, ['admin', 'operator']))
                <a href="{{ url('/repair-requests/create') }}" class="btn btn-primary btn-sm float-right">
                    <i class="fas fa-plus"></i>
                    Ajukan Perbaikan
                </a>
            @endif
        </div>

        <div class="card-body">
            <div class="mb-3 position-relative">
                <form method="GET" action="{{ route('reports.repairs') }}" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                            placeholder="Cari forklift, pelapor, status...">

                        <div class="input-group-append">
                            <button class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>

                            @if (request('q'))
                                <a href="{{ route('reports.repairs') }}" class="btn btn-secondary">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </div>
                </form>

            </div>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table id="reportTable" class="table table-bordered">
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
                        @foreach ($repairs as $r)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $r->created_at->format('d-m-Y H:i') }}</td>
                                <td>{{ $r->user->name ?? '-' }}</td>

                                <td>
                                    @if ($r->forklift)
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
                                        $badge = match ($r->status) {
                                            'DIAJUKAN' => 'secondary',
                                            'DITUGASKAN' => 'warning',
                                            'SEDANG_DIKERJAKAN' => 'info',
                                            'MENUNGGU_SPAREPART' => 'dark',
                                            'SELESAI' => 'success',
                                            default => 'light',
                                        };
                                    @endphp
                                    <span class="badge badge-{{ $badge }}">
                                        {{ $r->status }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    @if ($r->status === 'SELESAI')
                                        <button class="btn btn-sm btn-info" data-toggle="modal"
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
                {{ $repairs->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    {{-- ================= MODAL DETAIL (DI LUAR TABLE) ================= --}}
    @foreach ($repairs as $r)
        @if ($r->status === 'SELESAI')
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
