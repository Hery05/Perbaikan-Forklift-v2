@extends('layouts.app')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Master User</h3>
        <a href="{{ route('users.create') }}"
           class="btn btn-primary btn-sm float-right">
           <i class="fas fa-plus"></i> Tambah User
        </a>
    </div>

    <div class="card-body table-responsive">

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th width="140">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($users as $u)
                <tr>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>
                        <span class="badge badge-info">
                            {{ ucfirst($u->role) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('users.edit',$u) }}"
                           class="btn btn-warning btn-sm">
                           Edit
                        </a>

                        <form action="{{ route('users.destroy',$u) }}"
                              method="POST"
                              style="display:inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Hapus user ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
