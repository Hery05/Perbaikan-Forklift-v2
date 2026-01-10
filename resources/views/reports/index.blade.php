@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-file-alt text-primary mr-1"></i>
            Laporan Perbaikan Forklift
        </h3>
    </div>

    <div class="card-body">

        {{-- FILTER --}}
        <form method="GET" class="form-inline mb-3">
            <label class="mr-2 font-weight-bold">Bulan:</label>
            <select name="bulan" class="form-control mr-2">
                <option value="">Semua</option>
                @for($i=1;$i<=12;$i++)
                    <option value="{{ $i }}" {{ $bulan==$i ? 'selected' : '' }}>
                        {{ date('F', mktime(0,0,0,$i,1)) }}
                    </option>
                @endfor
            </select>

            <button class="btn btn-primary mr-2">
                <i class="fas fa-filter"></i> Filter
            </button>

            <a href="{{ route('reports.pdf',['bulan'=>$bulan]) }}"
               class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
        </form>

        {{-- TABLE --}}
        <table class="table table-bordered table-sm">
            <thead class="bg-light">
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Forklift</th>
                    <th>Teknisi</th>
                    <th>Hasil</th>
                    <th>Durasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($repairs as $r)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $r->created_at->format('d M Y') }}</td>
                    <td>{{ $r->forklift->merk ?? '-' }}</td>
                    <td>{{ $r->technician->name ?? '-' }}</td>
                    <td>{{ $r->hasil_perbaikan }}</td>
                    <td>{{ $r->durasi_menit }} menit</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{ $repairs->links() }}

    </div>
</div>
@endsection
