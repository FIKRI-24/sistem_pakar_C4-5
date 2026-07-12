@extends('layouts.app', ['title' => 'Login'])

@section('content')
    <style>
        .login-container {
            max-width: 420px;
            margin: 40px auto;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .login-header {
            background: linear-gradient(135deg, #0f766e, #115e59);
            color: #ffffff;
            padding: 32px 24px;
            text-align: center;
            position: relative;
        }

        .login-header h1 {
            margin: 8px 0 0;
            font-size: 1.6rem;
            font-weight: 700;
            letter-spacing: -0.025em;
        }

        .login-header p {
            margin: 6px 0 0;
            font-size: 0.875rem;
            color: #ccfbf1;
            opacity: 0.9;
        }

        .login-body {
            padding: 32px 28px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 6px;
            font-size: 0.875rem;
            font-weight: 600;
            color: #334155;
        }

        .form-input {
            width: 100%;
            box-sizing: border-box;
            min-height: 44px;
            padding: 10px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 0.95rem;
            background-color: #ffffff;
            color: #1e293b;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #0f766e;
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.15);
        }

        .login-button {
            width: 100%;
            min-height: 44px;
            background-color: #0f766e;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
        }

        .login-button:hover {
            background-color: #0d9488;
        }

        .login-button:active {
            transform: scale(0.98);
        }

        .remember-me {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
            cursor: pointer;
            user-select: none;
            font-size: 0.875rem;
            color: #475569;
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            accent-color: #0f766e;
            cursor: pointer;
        }

        .demo-box {
            margin-top: 24px;
            padding: 16px;
            background-color: #f8fafc;
            border: 1px dashed #e2e8f0;
            border-radius: 8px;
            font-size: 0.85rem;
            color: #475569;
        }

        .demo-title {
            font-weight: 700;
            color: #334155;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .demo-badge {
            background-color: #e2e8f0;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: monospace;
            font-size: 0.8rem;
            color: #1e293b;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.825rem;
            margin-top: 6px;
            display: block;
        }

        .school-icon {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            margin-bottom: 8px;
            margin-inline: auto;
        }
    </style>

    <div class="login-container">
        <div class="login-header">
            <div class="school-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-graduation-cap"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"/><path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/></svg>
            </div>
            <h1>Login Pengguna</h1>
            <p>Sistem Pakar Rekomendasi Karir Siswa</p>
        </div>

        <div class="login-body">
            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="username">Username</label>
                    <input class="form-input" id="username" name="username" type="text" value="{{ old('username') }}" required autofocus autocomplete="username" placeholder="Masukkan username Anda">
                    @error('username')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input class="form-input" id="password" name="password" type="password" required autocomplete="current-password" placeholder="Masukkan password Anda">
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <label class="remember-me">
                    <input name="remember" type="checkbox" value="1">
                    <span>Ingat saya di perangkat ini</span>
                </label>

                <button class="login-button" type="submit">Masuk ke Sistem</button>
            </form>

            <div class="demo-box">
                <div class="demo-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                    Informasi Akun Demo (Password: <span style="font-family: monospace;">password</span>)
                </div>
                <div style="display: flex; flex-direction: column; gap: 4px; margin-top: 8px;">
                    <div>• Admin: <span class="demo-badge">admin_sistem</span></div>
                    <div>• Guru BK: <span class="demo-badge">guru_bk</span></div>
                    <div>• Siswa: <span class="demo-badge">siswa_demo</span></div>
                </div>
            </div>
        </div>
    </div>
@endsection
