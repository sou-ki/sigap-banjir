@extends('layouts.auth')

@section('title', 'Daftar Akun — SIGAP Banjir')

@section('form')

<a href="{{ route('masuk') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 mb-8 transition-colors">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
    </svg>
    Kembali ke halaman masuk
</a>

<h1 class="text-3xl font-extrabold text-gray-900 mb-1">Daftar Akun Warga</h1>
<p class="text-sm text-gray-500 mb-7">
    Pendaftaran publik hanya membuat akun <span class="font-semibold text-gray-700">Masyarakat</span>. Akun petugas, koordinator, dan admin dikelola oleh administrator.
</p>

<form action="{{ route('register') }}" method="POST" class="space-y-4">
    @csrf

    {{-- Validation errors --}}
    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-xl p-3">
        <ul class="text-xs text-red-700 space-y-1 list-disc list-inside">
            @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Nama --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">
            Nama Lengkap <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
            </span>
            <input type="text" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Nama lengkap Anda"
                   class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow">
        </div>
    </div>

    {{-- Email --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">
            Email <span class="text-red-500">*</span>
        </label>
        <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@email.com"
               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow">
    </div>

    {{-- Nomor Telepon --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">
            Nomor Telepon <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                </svg>
            </span>
            <input type="tel" name="phone" value="{{ old('phone') }}" required autocomplete="tel" placeholder="08xx-xxxx-xxxx"
                   class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow">
        </div>
        <p class="text-xs text-gray-400 mt-1">Tidak ditampilkan di peta publik.</p>
    </div>

    {{-- Password + Konfirmasi --}}
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                Kata Sandi <span class="text-red-500">*</span>
            </label>
            <input type="password" name="password" required minlength="8" autocomplete="new-password" placeholder="Minimal 8 karakter"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                Konfirmasi <span class="text-red-500">*</span>
            </label>
            <input type="password" name="password_confirmation" required minlength="8" autocomplete="new-password" placeholder="Ulangi kata sandi"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow">
        </div>
    </div>

    {{-- Agreement --}}
    <div>
        <label class="flex items-start gap-2.5 cursor-pointer">
            <input type="checkbox" name="agree" required class="w-4 h-4 mt-0.5 rounded border-gray-300 text-blue-600 flex-shrink-0">
            <span class="text-sm text-gray-600 leading-snug">
                Saya menyetujui penggunaan data saya untuk keperluan koordinasi tanggap banjir sesuai kebijakan privasi prototipe ini.
            </span>
        </label>
    </div>

    {{-- Submit --}}
    <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl text-sm transition-colors shadow-sm">
        Buat Akun
    </button>

    <p class="text-center text-sm text-gray-500">
        Sudah punya akun?
        <a href="{{ route('masuk') }}" class="font-semibold text-blue-600 hover:text-blue-800">Masuk di sini</a>
    </p>
</form>

@endsection
