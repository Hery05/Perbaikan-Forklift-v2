@extends('layouts.app')

@section('content')
<div class="container-fluid">

{{-- SUMMARY --}}
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $total }}</h3>
                <p>Total Perbaikan</p>
            </div>
            <div class="icon"><i class="fas fa-wrench"></i></div>
        </div>
    </div>

    @foreach($byStatus as $status => $count)
    <div class="col-lg-3 col-6">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{ $count }}</h3>
                <p>{{ $status }}</p>
            </div>
            <div class="icon"><i class="fas fa-clipboard-check"></i></div>
        </div>
    </div>
    @endforeach
</div>

{{-- PER TEKNISI --}}
<div class="card">
    <div class="card-header bg-primary">
        <h3 class="card-title">
            <i class="fas fa-users-cog"></i> Perbaikan per Teknisi
        </h3>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Teknisi</th>
                    <th>Total Perbaikan</th>
                </tr>
            </thead>
            <tbody>
            @foreach($byTechnician as $t)
                <tr>
                    <td>{{ $t->technician->name ?? '-' }}</td>
                    <td>{{ $t->total }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

</div>
@endsection
