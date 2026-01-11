@extends('layouts.app')

@section('content')
    <div class="card shadow-sm">

        <div class="card-header">
            <h3 class="card-title mb-0">
                <i class="fas fa-boxes text-primary"></i>
                Master Sparepart
            </h3>

            <a href="{{ route('sparepart.create') }}" class="btn btn-primary btn-sm float-right">
                <i class="fas fa-plus"></i> Tambah
            </a>
        </div>

        <div class="card-body">

            {{-- SEARCH --}}
            <form method="GET" action="{{ route('sparepart.index') }}" class="mb-3 position-relative">
                <div class="input-group">
                    <input type="text" name="q" value="{{ $keyword ?? '' }}" class="form-control"
                        placeholder="Cari kode / nama sparepart..." autocomplete="off">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                {{-- REKOMENDASI --}}
                @if (!empty($keyword) && $spareparts->count())
                    <div class="border bg-white mt-1 rounded shadow-sm">
                        @foreach ($spareparts->take(5) as $s)
                            <a href="{{ route('sparepart.edit', $s->id) }}"
                                class="d-block px-3 py-2 text-dark text-decoration-none hover-bg">
                                <strong>{{ $s->kode_sparepart }}</strong> – {{ $s->nama_sparepart }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </form>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%">#</th>
                            <th>Kode</th>
                            <th>Nama Sparepart</th>
                            <th width="10%">Stok</th>
                            <th width="10%">Satuan</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($spareparts as $sp)
                            <tr>
                                <td>{{ $loop->iteration + ($spareparts->currentPage() - 1) * $spareparts->perPage() }}</td>
                                <td><strong>{{ $sp->kode_sparepart }}</strong></td>
                                <td>{{ $sp->nama_sparepart }}</td>
                                <td>
                                    <span class="badge badge-{{ $sp->stok <= 3 ? 'danger' : 'success' }}">
                                        {{ $sp->stok }}
                                    </span>
                                </td>
                                <td>{{ $sp->satuan }}</td>
                                <td class="text-center">
                                    <a href="{{ route('sparepart.edit', $sp->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('sparepart.destroy', $sp->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Hapus sparepart ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    Data sparepart tidak ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div class="dataTables_info">
                            Showing {{ $spareparts->firstItem() }}
                            to {{ $spareparts->lastItem() }}
                            of {{ $spareparts->total() }} entries
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-7">
                        <div class="float-right">
                            {{ $spareparts->links() }}
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    {{-- STYLE KECIL --}}
    <style>
        .hover-bg:hover {
            background-color: #f4f6f9;
        }
    </style>
@endsection
