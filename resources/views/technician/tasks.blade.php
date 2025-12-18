@extends('layouts.app')

@section('content')
<div class="container-fluid">

<div class="card">
    <div class="card-header bg-primary">
        <h3 class="card-title">
            <i class="fas fa-tools"></i> Tugas Perbaikan Teknisi
        </h3>
    </div>

    <div class="card-body">

        {{-- SEARCH --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" id="searchTask" class="form-control"
                       placeholder="Cari ID / Forklift / Status">
            </div>
        </div>

        {{-- TABLE --}}
        <div class="table-responsive">
        <table class="table table-hover table-bordered" id="taskTable">
            <thead class="thead-light">
                <tr>
                    <th width="5%">ID</th>
                    <th>Forklift</th>
                    <th>Kerusakan</th>
                    <th width="20%">Status</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($tasks as $t)
                <tr>
                    <td>#{{ $t->id }}</td>
                    <td>{{ optional($t->forklift)->merk ?? '-' }} | {{ optional($t->forklift)->tipe ?? '-' }}</td>
                    <td>{{ $t->jenis_kerusakan }}</td>
                    <td>
                        <span class="badge
                            @if($t->status=='DITUGASKAN') badge-warning
                            @elseif($t->status=='SEDANG_DIKERJAKAN') badge-info
                            @elseif($t->status=='MENUNGGU_SPAREPART') badge-secondary
                            @elseif($t->status=='SPAREPART_TERSEDIA') badge-primary
                            @elseif($t->status=='SELESAI') badge-success
                            @endif">
                            {{ $t->status }}
                        </span>
                    </td>
                    <td>
                        <a href="/tasks/{{ $t->id }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-3 d-flex justify-content-end">
            {{ $tasks->links() }}
        </div>

    </div>
</div>

</div>

{{-- SEARCH JS --}}
<script>
document.getElementById('searchTask').addEventListener('keyup', function () {
    let value = this.value.toLowerCase();
    let rows = document.querySelectorAll('#taskTable tbody tr');

    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value)
            ? ''
            : 'none';
    });
});
</script>
@endsection
