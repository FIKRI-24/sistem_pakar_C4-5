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
            <div style="width: 80px; height: 80px; background: #ffffff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); padding: 4px;">
                <img src="{{ asset('images/logo-smkn1.jpg') }}" alt="Logo SMKN 1 Hiliran Gumanti" style="max-width: 100%; max-height: 100%; object-fit: contain; border-radius: 50%;">
            </div>
            <h1 style="margin: 0 0 4px; font-size: 1.35rem; font-weight: 800; color: #ffffff; letter-spacing: -0.02em; text-transform: uppercase;">
                SMKN 1 Hiliran Gumanti
            </h1>
            <p style="margin: 0; font-size: 0.85rem; color: #ccfbf1; font-weight: 600;">
                Sistem Pakar Rekomendasi Karir Siswa (Metode C4.5)
            </p>
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

                <button class="login-button" type="submit" style="margin-bottom:16px;">Masuk ke Sistem</button>

                <div style="text-align: center; font-size: 0.875rem; color: #64748b;">
                    Belum memiliki akun? <a href="{{ route('register') }}" style="color: #0f766e; font-weight: 750; text-decoration: none;">Daftar Mandiri (Siswa)</a>
                </div>
            </form>


        </div>
    </div>
@endsection
