@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-cogs text-primary"></i>
                Master Sparepart
            </h3>
            <a href="{{ route('spareparts.create') }}" class="btn btn-primary btn-sm float-right">
                <i class="fas fa-plus"></i> Tambah
            </a>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="bg-light">
                    <tr>
                        <th>#</th>
                        <th>Kode Sparepart</th>
                        <th>Nama Sparepart</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($spareparts as $s)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $s->kode_sparepart }}</td>
                            <td>{{ $s->nama_sparepart }}</td>
                            <td>
                                <span class="badge {{ $s->stok > 0 ? 'badge-success' : 'badge-danger' }}">
                                    {{ $s->stok }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('spareparts.edit', $s) }}" class="btn btn-warning btn-sm">Edit</a>

                                <form method="POST" action="{{ route('spareparts.destroy', $s) }}" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus sparepart?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                <tbody>
            </table>

            {{ $spareparts->links() }}
        </div>
    </div>
@endsection
