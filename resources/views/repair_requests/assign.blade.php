@extends('layouts.app')

@section('content')
<h4>Assign Teknisi</h4>

<form method="POST" action="/repair-requests/{{ $repair->id }}/assign">
@csrf

<select name="technician_id" class="form-control mb-3">
@foreach($technicians as $t)
<option value="{{ $t->id }}">{{ $t->name }}</option>
@endforeach
</select>

<button class="btn btn-primary">Assign</button>
</form>
@endsection
