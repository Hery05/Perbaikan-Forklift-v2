@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header bg-warning">
        <h3 class="card-title">
            <i class="fas fa-user-edit mr-1"></i> Edit User
        </h3>
    </div>

    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="card-body">

            <div class="form-group">
                <label>Nama</label>
                <input name="name"
                       value="{{ old('name', $user->name) }}"
                       class="form-control"
                       required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input name="email"
                       type="email"
                       value="{{ old('email', $user->email) }}"
                       class="form-control"
                       required>
            </div>

            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    @foreach(['admin','operator','coordinator','technician','sparepart'] as $role)
                        <option value="{{ $role }}"
                            {{ $user->role == $role ? 'selected' : '' }}>
                            {{ ucfirst($role) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Password Baru (opsional)</label>
                <div class="input-group">
                    <input id="password"
                           name="password"
                           type="password"
                           class="form-control"
                           placeholder="Kosongkan jika tidak diubah">

                    <div class="input-group-append">
                        <span class="input-group-text"
                              style="cursor:pointer"
                              onclick="togglePassword()">
                            <i id="eye" class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>
                <small class="text-muted">
                    Isi hanya jika ingin mengganti password
                </small>
            </div>

        </div>

        <div class="card-footer">
            <button class="btn btn-warning">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('users.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>
        </div>
    </form>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const eye   = document.getElementById('eye');

    if (input.type === 'password') {
        input.type = 'text';
        eye.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        eye.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
@endsection
