@extends('layouts.dashboard')
@section('title', 'Notifikasi')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-xl font-extrabold text-gray-900">Notifikasi</h2>
        <button class="text-sm font-medium text-gray-500 border border-gray-200 rounded-lg px-4 py-2 hover:bg-gray-50 transition-colors">
            Tandai semua dibaca
        </button>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
        {{-- Empty state --}}
        <div class="py-20 flex flex-col items-center text-center">
            <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </div>
            <p class="text-base font-bold text-gray-700">Belum ada notifikasi</p>
            <p class="text-sm text-gray-400 mt-1">Notifikasi terkait laporan dan pembaruan kondisi banjir akan muncul di sini.</p>
        </div>
    </div>
</div>
@endsection
