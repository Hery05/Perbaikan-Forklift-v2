<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>SIMPF</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- AdminLTE --}}
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

    {{-- Elegant White UI --}}
    <style>
        body {
            background-color: #f4f6f9;
        }

        .content-wrapper {
            background-color: #f4f6f9;
        }

        .brand-link {
            background: #ffffff;
            border-bottom: 1px solid #dee2e6;
        }

        .nav-sidebar .nav-link.active {
            background-color: #e7f1ff;
            color: #0d6efd;
            font-weight: 600;
        }

        .navbar {
            border-bottom: 1px solid #dee2e6;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

    {{-- ================= NAVBAR ================= --}}
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">

        {{-- Left --}}
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            {{-- waktu zone --}}
            <li class="nav-item d-none d-sm-inline-block">
                <span class="nav-link font-weight-bold text-secondary">
                    <i id="greet-icon" class="fas mr-1"></i>
                    <span id="greeting-text"></span>,
                    {{ auth()->user()->name }}
                </span>
            </li>

        </ul>

        {{-- Right --}}
        <ul class="navbar-nav ml-auto align-items-center">
            <li class="nav-item mr-3 text-muted">
                <i class="far fa-clock mr-1"></i>
                <span id="clock"></span>
            </li>
{{-- 
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>

                    @php
                        $notifCount = auth()->user()->unreadNotifications->count();
                    @endphp

                    @if($notifCount > 0)
                        <span class="badge badge-danger navbar-badge">
                            {{ $notifCount }}
                        </span>
                    @endif
                </a>

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                    <span class="dropdown-item dropdown-header">
                        {{ $notifCount }} Notifikasi Baru
                    </span>

                    @forelse(auth()->user()->unreadNotifications->take(5) as $notif)
                        <a href="{{ url('/notifications/'.$notif->id) }}"
                        class="dropdown-item">
                            <i class="fas fa-tools mr-2 text-primary"></i>
                            {{ $notif->data['message'] ?? 'Notifikasi' }}
                            <span class="float-right text-muted text-sm">
                                {{ $notif->created_at->diffForHumans() }}
                            </span>
                        </a>
                    @empty
                        <span class="dropdown-item text-muted text-center">
                            Tidak ada notifikasi
                        </span>
                    @endforelse

                    <div class="dropdown-divider"></div>

                    <a href="{{ url('/notifications') }}"
                    class="dropdown-item dropdown-footer">
                        Lihat Semua
                    </a>
                </div>
            </li> --}}
            <li class="nav-item">
                <form action="/logout" method="POST">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>
    {{-- ================= END NAVBAR ================= --}}

    {{-- ================= SIDEBAR ================= --}}
    <aside class="main-sidebar sidebar-light-primary elevation-1">
        <a href="/dashboard" class="brand-link text-center">
            <i class="fas fa-industry text-primary mr-1"></i>
            <span class="brand-text font-weight-bold text-primary">
                PERBAIKAN FORKLIFT
            </span>
        </a>

        <div class="sidebar pt-3">
            @include('layouts.sidebar')
        </div>
    </aside>
    {{-- ================= END SIDEBAR ================= --}}

    {{-- ================= CONTENT ================= --}}
    <div class="content-wrapper p-3">

        {{-- ================= GLOBAL ALERT ================= --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm">
            <i class="fas fa-check-circle mr-1"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm">
            <i class="fas fa-times-circle mr-1"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show shadow-sm">
            <i class="fas fa-exclamation-triangle mr-1"></i>
            {{ session('warning') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if (session('info'))
        <div class="alert alert-info alert-dismissible fade show shadow-sm">
            <i class="fas fa-info-circle mr-1"></i>
            {{ session('info') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm">
            <i class="fas fa-ban mr-1"></i>
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif
    {{-- ================= END ALERT ================= --}}

        @yield('content')

    </div>
    {{-- ================= END CONTENT ================= --}}

</div>

{{-- Scripts --}}
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

{{-- Auto-hide alert setelah 5 detik: --}}
<script>
    setTimeout(() => {
        $('.alert').alert('close');
    }, 4000);
</script>


{{-- Realtime Clock --}}
<script>
function updateGreeting() {
    const hour = new Date().getHours();
    let greeting = '';
    let icon = '';

    if (hour >= 5 && hour < 11) {
        greeting = 'Selamat Pagi';
        icon = 'fa-sun text-warning';
    } else if (hour >= 11 && hour < 15) {
        greeting = 'Selamat Siang';
        icon = 'fa-cloud-sun text-orange';
    } else if (hour >= 15 && hour < 18) {
        greeting = 'Selamat Sore';
        icon = 'fa-sunset text-danger';
    } else {
        greeting = 'Selamat Malam';
        icon = 'fa-moon text-primary';
    }

    document.getElementById('greeting-text').innerText = greeting;
    document.getElementById('greet-icon').className = 'fas ' + icon;
}

function updateClock() {
    const now = new Date();
    const options = {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    };

    document.getElementById('clock').innerText =
        now.toLocaleDateString('id-ID', options);
}

updateGreeting();
updateClock();
setInterval(updateClock, 1000);
</script>
</body>
</html>
