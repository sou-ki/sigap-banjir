@extends('layouts.auth')

@section('title', 'Atur Ulang Kata Sandi — SIGAP Banjir')

@section('form')

<a href="{{ route('masuk') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 mb-8 transition-colors">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
    </svg>
    Kembali ke halaman masuk
</a>

<h1 class="text-3xl font-extrabold text-gray-900 mb-1">Atur Ulang Kata Sandi</h1>
<p class="text-sm text-gray-500 mb-7">Buat kata sandi baru untuk akun Anda.</p>

@if ($errors->any())
<div class="mb-5 bg-red-50 border border-red-200 rounded-xl p-4 text-sm text-red-700" role="alert">
    <ul class="list-disc list-inside space-y-1">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('password.update') }}" method="POST" class="space-y-5">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email', $email) }}" required autocomplete="email"
               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow">
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Kata Sandi Baru</label>
        <input id="password" type="password" name="password" required minlength="8" autocomplete="new-password"
               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow">
        <p class="text-xs text-gray-400 mt-1">Minimal 8 karakter.</p>
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Kata Sandi Baru</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required minlength="8" autocomplete="new-password"
               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow">
    </div>

    <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl text-sm transition-colors shadow-sm">
        Simpan Kata Sandi Baru
    </button>
</form>

@endsection
