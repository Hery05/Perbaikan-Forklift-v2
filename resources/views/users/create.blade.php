@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-user-plus mr-1"></i>
                Tambah User
            </h5>
        </div>

        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <div class="card-body">

                {{-- NAMA --}}
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           placeholder="Nama lengkap"
                           required>
                </div>

                {{-- EMAIL --}}
                <div class="form-group">
                    <label>Email</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           placeholder="email@domain.com"
                           required>
                </div>

                {{-- ROLE --}}
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-control" required>
                        <option value="">-- pilih role --</option>
                        <option value="admin">Admin</option>
                        <option value="operator">Operator</option>
                        <option value="coordinator">Coordinator</option>
                        <option value="technician">Technician</option>
                        <option value="sparepart">Sparepart</option>
                    </select>
                </div>

                {{-- PASSWORD --}}
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-group">
                        <input id="password"
                               name="password"
                               type="password"
                               class="form-control"
                               placeholder="Minimal 6 karakter"
                               required>

                        <div class="input-group-append">
                            <button type="button"
                                    class="btn btn-outline-secondary"
                                    onclick="togglePassword()">
                                <i id="eyeIcon" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card-footer">
                <a href="{{ route('users.index') }}"
                   class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPT TOGGLE PASSWORD --}}
<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('eyeIcon');

    if (!input) return;

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endsection
