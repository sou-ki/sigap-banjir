@extends('layouts.petugas')
@section('title', 'Profil')

@section('content')
<div class="p-5 max-w-xl">
    <div class="mb-5">
        <h2 class="text-xl font-extrabold text-gray-900">Profil</h2>
        <p class="text-sm text-gray-500">Kelola informasi akun Anda.</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="flex items-center gap-4 px-6 py-5 border-b border-gray-100">
            <div class="w-14 h-14 rounded-full bg-gray-600 flex items-center justify-center text-white text-xl font-extrabold flex-shrink-0">CN</div>
            <div>
                <p class="text-base font-bold text-gray-900">Cut Nurmala</p>
                <p class="text-sm text-gray-500">petugas@sigapbanjir.demo</p>
                <span class="inline-block mt-1 text-xs font-semibold text-blue-700 bg-blue-100 px-2.5 py-0.5 rounded-full">Petugas Penanggulangan Bencana</span>
            </div>
        </div>

        <form onsubmit="saveProfile(event)" class="px-6 py-5 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" value="Cut Nurmala" class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor Telepon</label>
                    <input type="tel" value="0812-0000-0002" class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-400 mt-1">Hanya terlihat oleh petugas berwenang.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input type="email" value="petugas@sigapbanjir.demo" disabled class="w-full border border-gray-100 rounded-lg px-3.5 py-2.5 text-sm bg-gray-50 text-gray-400 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Peran</label>
                    <input type="text" value="Petugas Penanggulangan Bencana" disabled class="w-full border border-gray-100 rounded-lg px-3.5 py-2.5 text-sm bg-gray-50 text-gray-400 cursor-not-allowed">
                    <p class="text-xs text-gray-400 mt-1">Peran hanya dapat diubah administrator.</p>
                </div>
            </div>

            <div id="profile-saved-p" class="hidden bg-green-50 border border-green-200 rounded-lg p-3 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                <p class="text-sm font-semibold text-green-800">Perubahan berhasil disimpan.</p>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold px-6 py-2.5 rounded-xl transition-colors shadow-sm">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function saveProfile(e) {
    e.preventDefault();
    const b = document.getElementById('profile-saved-p');
    b.classList.remove('hidden');
    setTimeout(() => b.classList.add('hidden'), 3000);
}
</script>
@endpush
