@extends('layouts.koordinator')
@section('title', 'Profil')

@section('content')
<div class="p-5">
    <div class="mb-5">
        <h2 class="text-xl font-extrabold text-gray-900">Profil</h2>
        <p class="text-sm text-gray-500">Kelola informasi Anda.</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 max-w-lg">
        {{-- Avatar + name --}}
        <div class="flex items-center gap-4 mb-6">
            <div class="w-14 h-14 rounded-full bg-teal-600 flex items-center justify-center text-white text-xl font-extrabold flex-shrink-0">TF</div>
            <div>
                <p class="font-bold text-gray-900 text-lg">Teuku Faisal</p>
                <p class="text-sm text-gray-400">koordinator@sigapbanjir.demo</p>
                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full bg-teal-100 text-teal-700 mt-1">Koordinator Relawan</span>
            </div>
        </div>

        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Nama Lengkap</label>
                    <input type="text" value="Teuku Faisal" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Nomor Telepon</label>
                    <input type="tel" value="0812-0000-0013" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <p class="text-xs text-gray-400 mt-1">Jangan ubah tanpa izin petugas berwenang.</p>
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Email</label>
                <input type="email" value="koordinator@sigapbanjir.demo" disabled class="w-full border border-gray-100 bg-gray-50 rounded-xl px-4 py-2.5 text-sm text-gray-400 cursor-not-allowed">
                <p class="text-xs text-gray-400 mt-1">Peran ini hanya dapat diubah oleh admin sistem.</p>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Peran</label>
                <input type="text" value="Koordinator Relawan" disabled class="w-full border border-gray-100 bg-gray-50 rounded-xl px-4 py-2.5 text-sm text-teal-600 font-semibold cursor-not-allowed">
            </div>
        </div>

        <div class="mt-6">
            <button onclick="alert('Demo: Perubahan disimpan!')" class="bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold px-6 py-2.5 rounded-xl transition-colors">
                Simpan Perubahan
            </button>
        </div>
    </div>
</div>
@endsection
