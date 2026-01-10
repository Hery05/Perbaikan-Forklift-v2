@extends('layouts.app')

@section('content')
<div class="container-fluid">

<div class="card shadow-sm">
    <div class="card-header bg-secondary text-white">
        <h3 class="card-title mb-0">
            <i class="fas fa-boxes mr-1"></i> Manajemen Sparepart
        </h3>
    </div>

    <div class="card-body">

        {{-- SEARCH --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text"
                       id="searchSparepart"
                       class="form-control"
                       placeholder="Cari ID / Forklift / Sparepart / Status">
            </div>
        </div>

        {{-- TABLE --}}
        <div class="table-responsive">
        <table class="table table-bordered table-hover table-sm" id="sparepartTable">
            <thead class="thead-light">
                <tr>
                    <th width="60">ID</th>
                    <th>Forklift</th>
                    <th>Nama Sparepart</th>
                    <th width="80">Jumlah</th>
                    <th width="140">Status</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>

            <tbody>
            @forelse($requests as $r)
                <tr>
                    <td>#{{ $r->id }}</td>

                    {{-- FORKLIFT --}}
                    <td>
                        {{ optional($r->repairRequest->forklift)->merk ?? '-' }}
                        |
                        {{ optional($r->repairRequest->forklift)->tipe ?? '-' }}
                    </td>

                    {{-- SPAREPART --}}
                    <td>{{ $r->nama_sparepart }}</td>

                    <td class="text-center">{{ $r->jumlah }}</td>

                    {{-- STATUS --}}
                    <td class="text-center">
                        <span class="badge
                            @if($r->status === 'DIPROSES') badge-warning
                            @elseif($r->status === 'DISETUJUI') badge-success
                            @elseif($r->status === 'DITOLAK') badge-danger
                            @else badge-secondary
                            @endif">
                            {{ $r->status }}
                        </span>
                    </td>

                    {{-- AKSI --}}
                    <td class="text-center">
                        @if($r->status == 'DIPROSES')
                            <form method="POST" action="/spareparts/{{ $r->id }}/DISETUJUI" class="d-inline">
                                @csrf
                                <button class="btn btn-success btn-sm">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>

                            <form method="POST" action="/spareparts/{{ $r->id }}/DITOLAK" class="d-inline">
                                @csrf
                                <button class="btn btn-danger btn-sm">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        @else
                            <span class="text-muted">Selesai</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        Tidak ada permintaan sparepart
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-3 d-flex justify-content-end">
            {{ $requests->links() }}
        </div>

    </div>
</div>

</div>

{{-- SEARCH JS --}}
<script>
document.getElementById('searchSparepart').addEventListener('keyup', function () {
    const keyword = this.value.toLowerCase();
    const rows = document.querySelectorAll('#sparepartTable tbody tr');

    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(keyword)
            ? ''
            : 'none';
    });
});
</script>
@endsection
