@extends('layouts.auth')

@section('title', 'Masuk — SIGAP Banjir')

@section('form')

<a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 mb-8 transition-colors">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
    </svg>
    Kembali ke beranda
</a>

@if (session('status'))
<div class="mb-5 bg-green-50 border border-green-200 rounded-xl p-4 text-sm text-green-800" role="status">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="currentColor">
        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/>
    </svg>
    {{ session('status') }}
</div>
@endif

@if ($errors->any())
<div class="mb-5 bg-red-50 border border-red-200 rounded-xl p-3" role="alert">
    <ul class="text-sm text-red-700 space-y-1 list-disc list-inside">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<h1 class="text-3xl font-extrabold text-gray-900 mb-1">Masuk</h1>
<p class="text-sm text-gray-500 mb-7">Masuk untuk melaporkan banjir atau mengelola operasi tanggap bencana.</p>

<form action="{{ route('login') }}" method="POST" class="space-y-4">
    @csrf

    {{-- Email --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
        <div class="relative">
            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z"/>
                </svg>
            </span>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@gmail.com" required autocomplete="email"
                   class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow">
        </div>
    </div>

    {{-- Password --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Kata Sandi</label>
        <div class="relative">
            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                </svg>
            </span>
            <input type="password" id="password-field" name="password" placeholder="Masukkan kata sandi" required autocomplete="current-password"
                   class="w-full border border-gray-200 rounded-xl pl-10 pr-12 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow">
            <button type="button" onclick="togglePassword()" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Remember + Forgot --}}
    <div class="flex items-center justify-between">
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="remember" checked class="w-4 h-4 rounded border-gray-300 text-blue-600">
            <span class="text-sm text-gray-700">Ingat Saya</span>
        </label>
        <a href="{{ route('lupa-sandi') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">Lupa kata sandi?</a>
    </div>

    {{-- Submit --}}
    <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl text-sm transition-colors shadow-sm">
        Masuk
    </button>

    {{-- Register link --}}
    <p class="text-center text-sm text-gray-500">
        Belum punya akun?
        <a href="{{ route('daftar') }}" class="font-semibold text-blue-600 hover:text-blue-800">Daftar Akun</a>
    </p>
</form>

{{-- Prototype role selector --}}
<div class="mt-6 border border-blue-100 bg-blue-50 rounded-xl p-4">
    <div class="flex items-center gap-2 mb-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-blue-500" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/>
        </svg>
        <p class="text-xs font-bold text-blue-800 uppercase tracking-wide">AKUN DEMO PROTOTIPE</p>
    </div>
    <p class="text-xs text-blue-600 mb-3">Klik untuk mengisi kredensial secara otomatis, lalu tekan <strong>Masuk</strong>.</p>
    <div class="grid grid-cols-1 gap-2">
        @foreach([
            ['Petugas BPBD',           'petugas@sigapbanjir.demo',       'petugas123'],
            ['Koordinator Relawan',    'koordinator@sigapbanjir.demo',   'koordinator123'],
            ['Admin Sistem',           'admin@sigapbanjir.demo',         'admin123'],
        ] as [$label, $email, $pass])
        <button type="button" onclick="quickFill('{{ $email }}','{{ $pass }}')"
                class="flex items-center gap-2.5 text-xs font-medium text-blue-700 bg-white border border-blue-200 rounded-lg px-3 py-2.5 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-colors text-left">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
            </svg>
            <span>{{ $label }}</span>
            <span class="ml-auto text-blue-400 font-normal">{{ $email }}</span>
        </button>
        @endforeach
    </div>
</div>

@endsection

@push('scripts')
<script>
function togglePassword() {
    const f = document.getElementById('password-field');
    f.type = f.type === 'password' ? 'text' : 'password';
}

function quickFill(email, pass) {
    document.querySelector('input[name=email]').value = email;
    document.querySelector('input[name=password]').value = pass;
    document.querySelector('input[name=email]').focus();
}
</script>
@endpush
