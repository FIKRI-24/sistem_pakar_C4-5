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

        html, body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            color: #334155;
            background: #f8fafc;
            overflow-x: hidden;
            width: 100%;
            max-width: 100vw;
        }

        a {
            color: inherit;
        }

        .shell {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            width: 100%;
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

        /* Sidebar layout and components */
        .app-container {
            display: flex;
            min-height: 100vh;
            background: #f8fafc;
            width: 100%;
            max-width: 100vw;
            overflow-x: hidden;
        }

        .sidebar {
            width: 270px;
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 28px 20px;
            position: fixed;
            height: 100vh;
            box-sizing: border-box;
            z-index: 100;
            transition: left 0.3s ease;
        }

        .sidebar-brand {
            font-size: 1.15rem;
            font-weight: 800;
            color: #0f766e;
            padding: 0 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: -0.025em;
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-top: 36px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            color: #475569;
            font-weight: 600;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.2s;
            font-size: 0.95rem;
        }

        .sidebar-link svg {
            color: #64748b;
            transition: color 0.2s;
        }

        .sidebar-link:hover {
            background: #f1f5f9;
            color: #0f766e;
        }

        .sidebar-link:hover svg {
            color: #0f766e;
        }

        .sidebar-link.active {
            background: #f1f5f9;
            color: #0f766e;
            font-weight: 700;
        }

        .sidebar-link.active svg {
            color: #0f766e;
        }

        .main-content {
            flex: 1;
            margin-left: 270px;
            background: #f8fafc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
            width: calc(100% - 270px);
            max-width: 100%;
            overflow-x: hidden;
        }

        .main-header {
            height: 70px;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 clamp(20px, 4vw, 40px);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .main-header-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.025em;
        }

        .main-body {
            padding: 32px clamp(20px, 4vw, 40px);
            flex: 1;
            box-sizing: border-box;
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
        }

        .profile-dropdown-btn {
            background: none;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 8px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 0.9rem;
            color: #1e293b;
            cursor: pointer;
            transition: all 0.2s;
        }

        .profile-dropdown-btn:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
        }

        .profile-dropdown-btn .role-indicator {
            font-size: 0.75rem;
            font-weight: 700;
            background: #f0fdf4;
            color: #0f766e;
            padding: 2px 8px;
            border-radius: 6px;
            text-transform: uppercase;
        }

        .profile-dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            margin-top: 8px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            width: 160px;
            overflow: hidden;
            z-index: 200;
        }

        .profile-dropdown-menu a {
            display: block;
            padding: 12px 16px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #475569;
            text-decoration: none;
            transition: background 0.15s;
        }

        .profile-dropdown-menu a:hover {
            background: #f8fafc;
        }

        /* Mobile specific styles */
        .mobile-sidebar-toggle {
            display: none;
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #0f766e;
            color: #ffffff;
            border: none;
            box-shadow: 0 10px 15px -3px rgba(15, 118, 110, 0.3);
            z-index: 150;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -270px;
            }

            .sidebar.open {
                left: 0;
                box-shadow: 10px 0 25px -5px rgba(0,0,0,0.1);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .main-header {
                padding: 0 16px;
                height: 60px;
            }

            .main-header-title {
                font-size: 1.1rem;
            }

            .main-body {
                padding: 16px 12px;
            }

            .mobile-sidebar-toggle {
                display: flex;
            }
        }
    </style>
</head>
<body>
    @auth
        <div class="app-container">
            <!-- Mobile Toggle Button -->
            <button class="mobile-sidebar-toggle" onclick="toggleMobileSidebar()" aria-label="Toggle Sidebar">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
            </button>

            <!-- Sidebar -->
            <aside class="sidebar" id="sidebar">
                <div>
                    <!-- Brand/Logo -->
                    <div class="sidebar-brand" style="display: flex; align-items: center; gap: 10px; padding: 18px 20px;">
                        <div style="width: 36px; height: 36px; background: #ffffff; border-radius: 50%; display: flex; align-items: center; justify-content: center; padding: 2px; box-shadow: 0 2px 8px rgba(0,0,0,0.12); flex-shrink: 0;">
                            <img src="{{ asset('images/logo-smkn1.jpg') }}" alt="Logo SMKN 1" style="max-width: 100%; max-height: 100%; object-fit: contain; border-radius: 50%;">
                        </div>
                        <div style="display: flex; flex-direction: column; line-height: 1.25;">
                            <span style="font-weight: 800; color: #0f172a; font-size: 0.9rem; letter-spacing: -0.01em;">SMKN 1 Hiliran Gumanti</span>
                            <span style="font-size: 0.7rem; color: #0f766e; font-weight: 700;">Sistem Pakar Karir C4.5</span>
                        </div>
                    </div>

                    <!-- Navigation Menu -->
                    <nav class="sidebar-menu">
                        @if (auth()->user()->isRole(\App\Models\User::ROLE_ADMIN))
                            <!-- Admin Navigation -->
                            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                <span>Dashboard</span>
                            </a>
                            <a href="{{ route('admin.siswas.index') }}" class="sidebar-link {{ request()->routeIs('admin.siswas.*') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                <span>Kelola Siswa</span>
                            </a>
                            <a href="{{ route('admin.kriterias.index') }}" class="sidebar-link {{ request()->routeIs('admin.kriterias.*') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="6" height="6" rx="1"/><path d="m3 17 2 2 4-4"/><path d="M13 6h8"/><path d="M13 12h8"/><path d="M13 18h8"/><rect x="3" y="11" width="6" height="6" rx="1"/></svg>
                                <span>Kriteria</span>
                            </a>
                            <a href="{{ route('admin.karirs.index') }}" class="sidebar-link {{ request()->routeIs('admin.karirs.*') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect width="20" height="14" x="2" y="6" rx="2"/></svg>
                                <span>Alternatif Karir</span>
                            </a>
                            <a href="{{ route('admin.tes.index') }}" class="sidebar-link {{ (request()->routeIs('admin.tes.*') && !request()->routeIs('admin.tes.hasil-tes') && !request()->routeIs('admin.tes.rekomendasi-karir')) ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/></svg>
                                <span>Tes</span>
                            </a>
                            <a href="{{ route('admin.soals.index') }}" class="sidebar-link {{ request()->routeIs('admin.soals.*') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><circle cx="12" cy="12" r="10"/><path d="M12 17h.01"/></svg>
                                <span>Bank Soal</span>
                            </a>
                            <a href="{{ route('admin.tes.hasil-tes') }}" class="sidebar-link {{ request()->routeIs('admin.tes.hasil-tes') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="18" y1="20" y2="10"/><line x1="12" x2="12" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="14"/></svg>
                                <span>Hasil Tes</span>
                            </a>
                            <a href="{{ route('admin.tes.rekomendasi-karir') }}" class="sidebar-link {{ request()->routeIs('admin.tes.rekomendasi-karir') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                <span>Rekomendasi Karir</span>
                            </a>
                            <a href="{{ route('admin.data-trainings.index') }}" class="sidebar-link {{ request()->routeIs('admin.data-trainings.*') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5V19A9 3 0 0 0 21 19V5"/><path d="M3 12A9 3 0 0 0 21 12"/></svg>
                                <span>Data Training</span>
                            </a>
                            <a href="{{ route('admin.c45.status') }}" class="sidebar-link {{ request()->routeIs('admin.c45.status') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                                <span>Status C4.5</span>
                            </a>
                            <a href="{{ route('admin.decision-tree.index') }}" class="sidebar-link {{ request()->routeIs('admin.decision-tree.*') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="6" y1="3" x2="6" y2="15"/><circle cx="18" cy="6" r="3"/><circle cx="6" cy="18" r="3"/><path d="M18 9a9 9 0 0 1-9 9"/></svg>
                                <span>Pohon Keputusan</span>
                            </a>
                        @elseif (auth()->user()->isRole(\App\Models\User::ROLE_GURU_BK))
                            <!-- Guru BK Navigation (MATCH PROPOSAL SCREENSHOT) -->
                            <a href="{{ route('guru-bk.dashboard') }}" class="sidebar-link {{ request()->routeIs('guru-bk.dashboard') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                <span>Dashboard</span>
                            </a>
                            <a href="{{ route('admin.tes.index') }}" class="sidebar-link {{ (request()->routeIs('admin.tes.*') && !request()->routeIs('admin.tes.hasil-tes') && !request()->routeIs('admin.tes.rekomendasi-karir')) ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/></svg>
                                <span>Tes</span>
                            </a>
                            <a href="{{ route('admin.soals.index') }}" class="sidebar-link {{ request()->routeIs('admin.soals.*') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><circle cx="12" cy="12" r="10"/><path d="M12 17h.01"/></svg>
                                <span>Bank Soal</span>
                            </a>
                            <a href="{{ route('admin.tes.hasil-tes') }}" class="sidebar-link {{ request()->routeIs('admin.tes.hasil-tes') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="18" y1="20" y2="10"/><line x1="12" x2="12" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="14"/></svg>
                                <span>Hasil Tes</span>
                            </a>
                            <a href="{{ route('admin.tes.rekomendasi-karir') }}" class="sidebar-link {{ request()->routeIs('admin.tes.rekomendasi-karir') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                <span>Rekomendasi Karir</span>
                            </a>
                            <a href="{{ route('admin.decision-tree.index') }}" class="sidebar-link {{ request()->routeIs('admin.decision-tree.*') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="6" y1="3" x2="6" y2="15"/><circle cx="18" cy="6" r="3"/><circle cx="6" cy="18" r="3"/><path d="M18 9a9 9 0 0 1-9 9"/></svg>
                                <span>Pohon Keputusan</span>
                            </a>
                        @elseif (auth()->user()->isRole(\App\Models\User::ROLE_SISWA))
                            <!-- Siswa Navigation -->
                            <a href="{{ route('siswa.dashboard') }}" class="sidebar-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                <span>Dashboard</span>
                            </a>
                            <a href="{{ route('siswa.biodata') }}" class="sidebar-link {{ request()->routeIs('siswa.biodata') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="7" r="4"/><path d="M4 21v-2a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v2"/></svg>
                                <span>Biodata Saya</span>
                            </a>
                            <a href="{{ route('siswa.konsultasi.index') }}" class="sidebar-link {{ request()->routeIs('siswa.konsultasi.*') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/></svg>
                                <span>Isi Kuesioner</span>
                            </a>
                            <a href="{{ route('siswa.hasil-tes.index') }}" class="sidebar-link {{ request()->routeIs('siswa.hasil-tes.*') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="18" y1="20" y2="10"/><line x1="12" x2="12" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="14"/></svg>
                                <span>Riwayat Hasil</span>
                            </a>
                        @endif
                    </nav>
                </div>

                <div>
                    <!-- Bottom Menu: Keluar -->
                    <div style="border-top: 1px solid #e2e8f0; padding-top: 16px; display: flex; flex-direction: column; gap: 8px;">
                        <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: none;">
                            @csrf
                        </form>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="sidebar-link" style="color: #ef4444;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                            <span>Keluar</span>
                        </a>
                    </div>
                </div>
            </aside>

            <!-- Main Content Area -->
            <div class="main-content">
                <!-- Header -->
                <header class="main-header">
                    <div class="main-header-title">
                        {{ $title ?? 'Dashboard' }}
                    </div>

                    <!-- Profile Dropdown -->
                    <div style="position: relative;" id="profile-dropdown-wrapper">
                        <button onclick="toggleProfileDropdown()" class="profile-dropdown-btn">
                            <span>{{ auth()->user()->name }}</span>
                            <span class="role-indicator">{{ str_replace('_', ' ', auth()->user()->role) }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-left:4px;"><polyline points="6 9 12 15 18 9"/></svg>
                        </button>
                        <div id="profile-dropdown-menu" class="profile-dropdown-menu">
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #ef4444; display: flex; align-items: center; gap: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                                <span>Keluar</span>
                            </a>
                        </div>
                    </div>
                </header>

                <!-- Body content -->
                <main class="main-body">
                    @yield('content')
                </main>
            </div>
        </div>
    @else
        <!-- Guest View (e.g. Login page) -->
        <main class="content">
            @yield('content')
        </main>
    @endauth

    <!-- Mobile Navigation Toggle Script -->
    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        }

        function toggleProfileDropdown() {
            const menu = document.getElementById('profile-dropdown-menu');
            if (menu.style.display === 'block') {
                menu.style.display = 'none';
            } else {
                menu.style.display = 'block';
            }
        }

        // Close dropdown when clicking outside
        window.addEventListener('click', function(e) {
            const wrapper = document.getElementById('profile-dropdown-wrapper');
            const menu = document.getElementById('profile-dropdown-menu');
            if (wrapper && menu && !wrapper.contains(e.target)) {
                menu.style.display = 'none';
            }
        });
    </script>
</body>
</html>
