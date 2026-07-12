<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'Sistem Pakar Karir Siswa') }}</title>
    <style>
        :root {
            color-scheme: light;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            line-height: 1.5;
        }

        body {
            margin: 0;
            min-height: 100vh;
            color: #334155;
            background: #f8fafc;
        }

        a {
            color: inherit;
        }

        .shell {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 14px clamp(20px, 5vw, 56px);
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }

        .brand {
            font-weight: 800;
            letter-spacing: -0.025em;
            color: #0f766e;
            font-size: 1.15rem;
        }

        .content {
            width: min(100% - 32px, 1040px);
            margin: 0 auto;
            padding: 32px 0;
        }

        .panel {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.05);
        }

        .panel-body {
            padding: clamp(24px, 4vw, 40px);
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 40px;
            padding: 0 18px;
            border: 0;
            border-radius: 8px;
            color: #ffffff;
            background: #0f766e;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .button:hover {
            background: #0d9488;
        }

        .button.secondary {
            color: #334155;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
        }

        .button.secondary:hover {
            background: #e2e8f0;
        }

        .button.danger {
            background: #ef4444;
        }

        .button.danger:hover {
            background: #dc2626;
        }

        .field {
            display: grid;
            gap: 8px;
            margin-bottom: 18px;
        }

        .field label {
            color: #334155;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .field input,
        .field select,
        .field textarea {
            min-height: 42px;
            padding: 0 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font: inherit;
            background: #ffffff;
            transition: border-color 0.2s, box-shadow 0.2s;
            color: #1e293b;
        }

        .field input:focus,
        .field select:focus,
        .field textarea:focus {
            outline: none;
            border-color: #0f766e;
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.15);
        }

        .field textarea {
            min-height: 110px;
            padding-block: 10px;
            resize: vertical;
        }

        .toolbar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 24px;
        }

        .toolbar h1 {
            margin: 8px 0 0;
            font-size: 1.8rem;
            font-weight: 750;
            letter-spacing: -0.025em;
            color: #1e293b;
        }

        .table-wrap {
            overflow-x: auto;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px 16px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: 0;
        }

        th {
            color: #475569;
            font-size: 0.85rem;
            font-weight: 700;
            background: #f8fafc;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        tr {
            transition: background-color 0.15s;
        }

        tbody tr:hover {
            background-color: #f8fafc;
        }

        .notice {
            margin-bottom: 20px;
            padding: 12px 18px;
            border-radius: 8px;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
            font-weight: 500;
        }

        .inline-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .error {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 4px;
        }

        .muted {
            color: #64748b;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            min-height: 26px;
            padding: 0 12px;
            border-radius: 999px;
            color: #0f766e;
            background: #f0fdf4;
            border: 1px solid #ccfbf1;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-actions a {
            color: #475569;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .nav-actions a:hover {
            color: #0f766e;
            background-color: #f0fdf4;
        }

        .nav-actions a.active {
            color: #0f766e;
            background-color: #f0fdf4;
        }

        ul.clean {
            padding-left: 20px;
            margin: 18px 0 0;
        }

        ul.clean li + li {
            margin-top: 8px;
        }

        /* Dashboard specific styling */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 16px;
            margin-top: 28px;
        }

        .dashboard-card {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            padding: 20px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .dashboard-card:hover {
            border-color: #0f766e;
            box-shadow: 0 10px 15px -3px rgba(15, 118, 110, 0.05), 0 4px 6px -2px rgba(15, 118, 110, 0.05);
            transform: translateY(-2px);
        }

        .dashboard-card .card-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            background: #f0fdf4;
            color: #0f766e;
            border-radius: 10px;
            flex-shrink: 0;
        }

        .dashboard-card .card-details h3 {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
            color: #1e293b;
        }

        .dashboard-card .card-details p {
            margin: 4px 0 0;
            font-size: 0.85rem;
            color: #64748b;
        }

        /* Pagination Styles */
        .pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            border-radius: 8px;
            gap: 6px;
            justify-content: center;
            margin: 24px 0 0;
        }

        .page-item {
            display: inline;
        }

        .page-item .page-link,
        .page-item span {
            position: relative;
            display: block;
            padding: 8px 14px;
            color: #475569;
            text-decoration: none;
            background-color: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .page-item.active span,
        .page-item.active .page-link {
            z-index: 3;
            color: #ffffff;
            background-color: #0f766e;
            border-color: #0f766e;
        }

        .page-item.disabled span,
        .page-item.disabled .page-link {
            color: #cbd5e1;
            pointer-events: none;
            background-color: #f8fafc;
            border-color: #e2e8f0;
        }

        .page-item:not(.active):not(.disabled) .page-link:hover {
            color: #0f766e;
            background-color: #f0fdf4;
            border-color: #0f766e;
        }

        @media (max-width: 640px) {
            .topbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .nav-actions {
                width: 100%;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="shell">
        @auth
            <header class="topbar">
                <div>
                    <div class="brand">Sistem Pakar Karir Siswa</div>
                </div>

                <div class="nav-actions">
                    <span class="role-badge" style="margin-right: 8px;">{{ str_replace('_', ' ', auth()->user()->role) }}</span>
                    @if (auth()->user()->isRole(\App\Models\User::ROLE_ADMIN))
                        <a href="{{ route('admin.siswas.index') }}" class="{{ request()->routeIs('admin.siswas.*') ? 'active' : '' }}">Siswa</a>
                        <a href="{{ route('admin.kriterias.index') }}" class="{{ request()->routeIs('admin.kriterias.*') ? 'active' : '' }}">Kriteria</a>
                        <a href="{{ route('admin.karirs.index') }}" class="{{ request()->routeIs('admin.karirs.*') ? 'active' : '' }}">Karir</a>
                        <a href="{{ route('admin.tes.index') }}" class="{{ (request()->routeIs('admin.tes.*') || request()->routeIs('admin.tes.buat-lengkap')) ? 'active' : '' }}">Tes</a>
                        <a href="{{ route('admin.data-trainings.index') }}" class="{{ request()->routeIs('admin.data-trainings.*') ? 'active' : '' }}">Training</a>
                        <a href="{{ route('admin.c45.status') }}" class="{{ request()->routeIs('admin.c45.*') ? 'active' : '' }}">Status C4.5</a>
                    @elseif (auth()->user()->isRole(\App\Models\User::ROLE_SISWA))
                        <a href="{{ route('siswa.konsultasi.index') }}" class="{{ request()->routeIs('siswa.konsultasi.*') ? 'active' : '' }}">Konsultasi</a>
                        <a href="{{ route('siswa.hasil-tes.index') }}" class="{{ request()->routeIs('siswa.hasil-tes.*') ? 'active' : '' }}">Hasil Tes</a>
                    @elseif (auth()->user()->isRole(\App\Models\User::ROLE_GURU_BK))
                        <a href="{{ route('admin.tes.index') }}" class="{{ (request()->routeIs('admin.tes.*') || request()->routeIs('admin.tes.buat-lengkap')) ? 'active' : '' }}">Tes</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="button secondary" type="submit">Logout</button>
                    </form>
                </div>
            </header>
        @endauth

        <main class="content">
            @yield('content')
        </main>
    </div>
</body>
</html>
