@extends('layouts.auth')

@section('title', 'Lupa Kata Sandi — SIGAP Banjir')

@section('form')

<a href="{{ route('masuk') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 mb-8 transition-colors">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
    </svg>
    Kembali
</a>

<h1 class="text-3xl font-extrabold text-gray-900 mb-1">Lupa Kata Sandi</h1>
<p class="text-sm text-gray-500 mb-8">Masukkan email akun Anda untuk menerima tautan pengaturan ulang.</p>

@if (session('status'))
<div class="mb-5 bg-green-50 border border-green-200 rounded-xl p-4 text-sm text-green-800" role="status">
    {{ session('status') }}
</div>
@endif

@if ($errors->any())
<div class="mb-5 bg-red-50 border border-red-200 rounded-xl p-4 text-sm text-red-700" role="alert">
    {{ $errors->first() }}
</div>
@endif

<form action="{{ route('password.email') }}" method="POST" class="space-y-5">
    @csrf
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@email.com"
               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow">
    </div>
    <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl text-sm transition-colors shadow-sm">
        Kirim Tautan
    </button>
</form>

@endsection
