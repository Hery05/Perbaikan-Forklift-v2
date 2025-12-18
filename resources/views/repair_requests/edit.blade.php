@extends('layouts.app')

@section('content')
<h4>Validasi Permintaan</h4>

<form method="POST" action="/repair-requests/{{ $repair->id }}">
@csrf
@method('PUT')

<select name="forklift_id" class="form-control mb-2" required>
    @foreach($forklifts as $f)
        <option value="{{ $f->id }}"
            {{ old('forklift_id', $repair->forklift_id) == $f->id ? 'selected' : '' }}>
            {{ $f->merk }} {{ $f->tipe }}
        </option>
    @endforeach
</select>

<input name="jenis_kerusakan" class="form-control mb-2" placeholder="Jenis Kerusakan">
<input name="prioritas" class="form-control mb-2" placeholder="Prioritas">

<button class="btn btn-primary">Simpan & Tugaskan</button>
</form>
@endsection
