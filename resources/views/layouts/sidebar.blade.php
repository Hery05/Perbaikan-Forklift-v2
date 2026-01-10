@php
    $role = auth()->user()->role;
@endphp

<nav class="mt-3">
    <ul class="nav nav-pills nav-sidebar nav-flat flex-column" data-widget="treeview" role="menu" data-accordion="false">

        {{-- DASHBOARD --}}
        <li class="nav-item">
            <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="nav-icon fas fa-chart-line"></i>
                <p>Dashboard</p>
            </a>
        </li>

        {{-- ================= ADMIN ================= --}}
        @if ($role === 'admin')
            <li class="nav-header">ADMIN MENU</li>

            <li class="nav-item">
                <a href="{{ url('/reports/repairs') }}"
                    class="nav-link {{ request()->is('reports/repairs') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-plus-circle"></i>
                    <p>Ajukan Perbaikan</p>
                </a>
            </li>
            {{-- Sparepart --}}
            @if (in_array(auth()->user()->role, ['admin', 'sparepart']))
                <li class="nav-item">
                    <a href="{{ route('spareparts.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Master Sparepart</p>
                    </a>
                </li>
            @endif


            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users-cog"></i>
                    <p>Master User</p>
                </a>
            </li>

            <li class="nav-item">
                {{-- <a href="{{ url('/reports') }}"
               class="nav-link {{ request()->is('reports*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-file-alt"></i>
                <p>Laporan</p>
            </a> --}}

                <a href="{{ route('reports.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>Laporan</p>
                </a>
            </li>
        @endif
        {{-- ================= USER ================= --}}
        @if (auth()->user()->role === 'operator')
            <li class="nav-item">
                <a href="{{ route('reports.repairs') }}"
                    class="nav-link {{ request()->is('reports/repairs') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>Buat Laporan Perbaikan</p>
                </a>
            </li>
        @endif
        {{-- ================= COORDINATOR ================= --}}
        @if ($role === 'coordinator')
            <li class="nav-header">COORDINATOR MENU</li>

            <li class="nav-item">
                <a href="{{ url('/repair-requests') }}"
                    class="nav-link {{ request()->is('repair-requests*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-clipboard-list"></i>
                    <p>Master Request</p>
                </a>
            </li>
        @endif

        {{-- ================= TECHNICIAN ================= --}}
        @if ($role === 'technician')
            <li class="nav-header">TECHNICIAN MENU</li>

            <li class="nav-item">
                <a href="{{ url('/tasks') }}" class="nav-link {{ request()->is('tasks*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tools"></i>
                    <p>Tugas Perbaikan</p>
                </a>
            </li>
        @endif

        {{-- ================= SPAREPART ================= --}}
        @if ($role === 'sparepart')
            <li class="nav-header">SPAREPART MENU</li>

            <li class="nav-item">
                <a href="{{ url('/spareparts') }}"
                    class="nav-link {{ request()->is('spareparts*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cogs"></i>
                    <p>Manajemen Sparepart</p>
                </a>
            </li>
        @endif

    </ul>
</nav>
