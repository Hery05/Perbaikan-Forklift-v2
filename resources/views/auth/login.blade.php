<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Sistem Perbaikan Forklift</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page">

<div class="login-box">
    <div class="login-logo">
        <b>SIM</b>PF
        <p class="text-muted text-sm mb-0">Sistem Informasi Perbaikan Forklift</p>
    </div>

    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <h5 class="mb-0">Login Pengguna</h5>
        </div>

        <div class="card-body login-card-body">
            <p class="login-box-msg">Masukkan email dan password</p>

            {{-- ERROR --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="/login">
                @csrf

                <!-- EMAIL -->
                <div class="input-group mb-3">
                    <input type="email" name="email"
                           class="form-control"
                           placeholder="Email"
                           required autofocus>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>

                <!-- PASSWORD -->
                <div class="input-group mb-3">
                    <input type="password" name="password"
                           class="form-control"
                           placeholder="Password"
                           required>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <!-- BUTTON -->
                <div class="row">
                    <div class="col-12">
                        <button type="submit"
                                class="btn btn-primary btn-block">
                            <i class="fas fa-sign-in-alt mr-1"></i> Login
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-footer text-center text-muted text-sm">
            © {{ date('Y') }} SIMPF
        </div>
    </div>
</div>

<!-- AdminLTE JS -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminlte/distjs/adminlte.min.js') }}"></script>

</body>
</html>
