@extends('layouts.dashboard')
@section('title', 'Profil')

@section('content')
<div class="p-6 max-w-2xl">

    <div class="mb-6">
        <h2 class="text-xl font-extrabold text-gray-900">Profil</h2>
        <p class="text-sm text-gray-500 mt-0.5">Kelola informasi akun Anda.</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        {{-- Avatar section --}}
        <div class="flex items-center gap-4 px-6 py-5 border-b border-gray-100">
            <div class="w-14 h-14 rounded-full bg-teal-500 flex items-center justify-center text-white text-xl font-extrabold flex-shrink-0">
                RT
            </div>
            <div>
                <p class="text-base font-bold text-gray-900">Report Telegram</p>
                <p class="text-sm text-gray-500">reporttelegram5@gmail.com</p>
                <span class="inline-block mt-1 text-xs font-semibold text-blue-700 bg-blue-100 px-2.5 py-0.5 rounded-full">Masyarakat</span>
            </div>
        </div>

        {{-- Form --}}
        <form onsubmit="saveProfile(event)" class="px-6 py-5 space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" value="Report Telegram"
                           class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor Telepon</label>
                    <input type="tel" value="085380166282"
                           class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-400 mt-1">Hanya terlihat oleh petugas berwenang.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input type="email" value="reporttelegram5@gmail.com" disabled
                           class="w-full border border-gray-100 rounded-lg px-3.5 py-2.5 text-sm bg-gray-50 text-gray-400 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Peran</label>
                    <input type="text" value="Masyarakat" disabled
                           class="w-full border border-gray-100 rounded-lg px-3.5 py-2.5 text-sm bg-gray-50 text-gray-400 cursor-not-allowed">
                    <p class="text-xs text-gray-400 mt-1">Peran hanya dapat diubah administrator.</p>
                </div>
            </div>

            {{-- Divider --}}
            <div class="border-t border-gray-100 pt-4">
                <h3 class="text-sm font-bold text-gray-800 mb-3">Ubah Kata Sandi</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Kata Sandi Baru</label>
                        <input type="password" placeholder="••••••••"
                               class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Kata Sandi</label>
                        <input type="password" placeholder="••••••••"
                               class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            {{-- Success banner (hidden) --}}
            <div id="profile-saved" class="hidden bg-green-50 border border-green-200 rounded-lg p-3 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/>
                </svg>
                <p class="text-sm font-semibold text-green-800">Perubahan berhasil disimpan.</p>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold px-6 py-2.5 rounded-xl transition-colors shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    {{-- Danger zone --}}
    <div class="mt-5 bg-white rounded-2xl border border-red-100 shadow-sm px-6 py-5">
        <h3 class="text-sm font-bold text-red-700 mb-1">Zona Berbahaya</h3>
        <p class="text-xs text-gray-500 mb-3">Tindakan di bawah ini tidak dapat diurungkan.</p>
        <button type="button" class="text-sm font-semibold text-red-600 border border-red-200 rounded-lg px-4 py-2 hover:bg-red-50 transition-colors">
            Hapus Akun Saya
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
function saveProfile(e) {
    e.preventDefault();
    const banner = document.getElementById('profile-saved');
    banner.classList.remove('hidden');
    setTimeout(() => banner.classList.add('hidden'), 3000);
}
</script>
@endpush
