@extends('layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <strong>Ajukan Permintaan Sparepart</strong>
        </div>

        <div class="card-body">
            @if (session('warning'))
                <div class="alert alert-warning">{{ session('warning') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Info Task --}}
            <div class="mb-3">
                <p><strong>Task ID:</strong> #{{ $task->id }}</p>
                <p><strong>Forklift:</strong> {{ $task->forklift->kode_forklift ?? '-' }} -
                    {{ $task->forklift->merk ?? '' }} {{ $task->forklift->tipe ?? '' }}</p>
                <p><strong>Teknisi:</strong> {{ $task->technician->name ?? auth()->user()->name }}</p>
                <p><strong>Status:</strong> {{ $task->status }}</p>
                <p><strong>Deskripsi Kerusakan:</strong> {{ $task->deskripsi_awal }}</p>
            </div>

            {{-- Form Ajukan Sparepart --}}
            <form method="POST" action="{{ route('tasks.sparepart.store', $task->id) }}">
                @csrf

                {{-- <div class="form-group mb-3">
                <label for="sparepart">Nama Sparepart</label>
                <input list="spareparts" id="sparepart" name="sparepart_id" class="form-control" required placeholder="Ketik nama sparepart">
                <datalist id="spareparts">
                    @foreach ($spareparts as $sparepart)
                        <option value="{{ $sparepart->kode_sparepart }}">{{ $sparepart->nama_sparepart }} (Stok: {{ $sparepart->stok }})</option>
                    @endforeach
                </datalist>
            </div> --}}
                <div class="form-group mb-3">
                    <label for="sparepart_name">Nama Sparepart</label>
                    <input list="spareparts" id="sparepart_name" class="form-control" placeholder="Ketik nama sparepart">
                    <input type="hidden" name="sparepart_id" id="sparepart_id" required>

                    <datalist id="spareparts">
                        @foreach ($spareparts as $sparepart)
                            <option data-id="{{ $sparepart->id }}" value="{{ $sparepart->nama_sparepart }}">
                                (Stok: {{ $sparepart->stok }})
                            </option>
                        @endforeach
                    </datalist>
                </div>

                <script>
                    const sparepartInput = document.getElementById('sparepart_name');
                    const sparepartId = document.getElementById('sparepart_id');

                    function setSparepartId() {
                        sparepartId.value = '';
                        const val = sparepartInput.value;
                        const options = document.getElementById('spareparts').options;
                        for (let i = 0; i < options.length; i++) {
                            if (options[i].value === val) {
                                sparepartId.value = options[i].dataset.id;
                                break;
                            }
                        }
                    }

                    // Event saat user mengetik / memilih
                    sparepartInput.addEventListener('input', setSparepartId);
                    sparepartInput.addEventListener('change', setSparepartId);
                </script>

                <div class="form-group mb-3">
                    <label for="jumlah">Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" required
                        value="{{ old('jumlah', 1) }}">
                </div>

                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-paper-plane"></i> Kirim Permintaan
                </button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
