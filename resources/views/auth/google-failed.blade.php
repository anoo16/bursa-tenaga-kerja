@extends('layouts.auth')

@section('title', 'Login Google Gagal - Bursa Tenaga Kerja')

@section('hero-text')

    <h1>Login Google Gagal</h1>

    <p>
        Terjadi kendala saat mencoba masuk menggunakan akun Google.
        Silakan kembali ke halaman login dan coba lagi.
    </p>

@endsection

@section('auth-form')

    <div class="text-center">

        <h2
            style="
                font-family: 'Sora', sans-serif;
                color: #1A4885;
                font-weight: 700;
                margin-bottom: 16px;
            "
        >
            Login Google Gagal
        </h2>

        <p
            style="
                color: #64748B;
                font-size: 14px;
                line-height: 1.7;
            "
        >
            {{ request('message', 'Login dengan Google gagal.') }}
        </p>

        <a
            href="/login"
            class="btn w-100 mt-3"
            style="
                background-color: #0F2854;
                color: #FFFFFF;
                font-weight: 600;
                border-radius: 8px;
                padding: 10px;
            "
        >
            Kembali ke Login
        </a>

    </div>

@endsection