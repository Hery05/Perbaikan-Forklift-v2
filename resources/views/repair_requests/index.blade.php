@extends('layouts.app')

@section('content')
<div class="card card-outline card-primary">

    {{-- HEADER --}}
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-clipboard-list"></i> Permintaan Perbaikan
        </h3>

        <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 220px;">
                <input type="text" id="searchInput"
                       class="form-control float-right"
                       placeholder="Cari deskripsi...">
                <div class="input-group-append">
                    <span class="btn btn-default">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- BODY --}}
    <div class="card-body table-responsive p-0">
        <table class="table table-hover table-bordered mb-0" id="requestTable">
            <thead class="thead-light">
                <tr>
                    <th width="60">ID</th>
                    <th>Deskripsi</th>
                    <th>Forklift</th>
                    <th width="140">Status</th>
                    <th width="220">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($requests as $r)
                <tr>
                    <td>{{ $r->id }}</td>

                    <td>
                        {{ Str::limit($r->deskripsi_awal, 80) }}
                    </td>
                    <td>
                        {{ optional($r->forklift)->merk ?? '-' }}
                        |
                        {{ optional($r->forklift)->tipe ?? '-' }}
                    </td>
                    <td>
                        @php
                            $badge = match($r->status) {
                                'DIAJUKAN' => 'info',
                                'DITUGASKAN' => 'warning',
                                'SEDANG DIKERJAKAN' => 'primary',
                                'MENUNGGU SPAREPART' => 'secondary',
                                'SELESAI' => 'success',
                                default => 'light'
                            };
                        @endphp

                        <span class="badge badge-{{ $badge }}">
                            {{ $r->status }}
                        </span>
                    </td>

                    <td>
                        @if(auth()->user()->role === 'coordinator')

                            @if($r->status === 'DIAJUKAN')
                                <a href="/repair-requests/{{ $r->id }}/edit"
                                   class="btn btn-sm btn-primary">
                                    <i class="fas fa-check"></i> Validasi
                                </a>
                            @endif

                            @if($r->status === 'DITUGASKAN' && !$r->technician_id)
                                <a href="/repair-requests/{{ $r->id }}/assign"
                                   class="btn btn-sm btn-warning">
                                    <i class="fas fa-user-cog"></i> Assign
                                </a>
                            @endif

                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        Tidak ada data permintaan
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- FOOTER --}}
    <div class="card-footer clearfix">
        <div class="float-right">
            {{ $requests->links() }}
        </div>
    </div>

</div>

{{-- SEARCH SCRIPT (JS ONLY) --}}
<script>
document.getElementById('searchInput').addEventListener('keyup', function () {
    const keyword = this.value.toLowerCase();
    const rows = document.querySelectorAll('#requestTable tbody tr');

    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(keyword) ? '' : 'none';
    });
});
</script>
@endsection
