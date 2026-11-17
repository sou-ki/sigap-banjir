@extends('layouts.admin')
@section('title', 'Manajemen Pengguna')

@section('content')
<div class="p-6">
    <div class="flex items-start justify-between mb-5 flex-wrap gap-3">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900">Manajemen Pengguna</h2>
            <p class="text-sm text-gray-500">Tambah, ubah, dan atur status akun pengguna.</p>
        </div>
        <button onclick="document.getElementById('modal-tambah').classList.remove('hidden')"
                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold px-4 py-2.5 rounded-xl transition-colors shadow-sm">
            + Tambah Pengguna
        </button>
    </div>

    {{-- Success banner --}}
    @if(session('success'))
    <div class="mb-5 bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>
        </svg>
        <p class="text-sm font-semibold text-green-800">{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        {{-- Search + filter --}}
        <div class="flex items-center gap-3 px-5 py-3 border-b border-gray-100 flex-wrap">
            <div class="relative flex-1 min-w-48">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" placeholder="Cari nama atau email..." class="w-full text-sm border border-gray-200 rounded-lg pl-9 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <select class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option>Semua peran</option>
                <option>Masyarakat</option>
                <option>Petugas Penanggulangan Bencana</option>
                <option>Koordinator Relawan</option>
                <option>Admin Sistem</option>
            </select>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        @foreach(['Nama','Peran','Status','Dibuat','Aksi'] as $h)
                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $u)
                    @php $isSelf = $u->id === auth()->id(); @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3.5">
                            <p class="font-semibold text-gray-900">{{ $u->name }}</p>
                            <p class="text-xs text-gray-400">{{ $u->email }}</p>
                        </td>
                        <td class="px-5 py-3.5 text-gray-700">{{ $u->roleLabel() }}</td>
                        <td class="px-5 py-3.5">
                            @if($u->is_active)
                            <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-green-100 text-green-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>
                                Aktif
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-gray-100 text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                                Nonaktif
                            </span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-gray-500 text-sm">{{ $u->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2">
                                {{-- Ubah --}}
                                <button onclick="openUbah('{{ $u->name }}','{{ $u->roleLabel() }}')"
                                        class="flex items-center gap-1 text-sm font-medium text-gray-600 hover:text-blue-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Ubah
                                </button>

                                @if(!$isSelf)
                                {{-- Toggle Aktif / Nonaktif --}}
                                <form method="POST" action="{{ route('admin.manajemen-pengguna.toggle', $u) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                            class="text-xs font-bold text-white px-3 py-1.5 rounded-lg transition-colors
                                                   {{ $u->is_active ? 'bg-red-500 hover:bg-red-600' : 'bg-green-600 hover:bg-green-700' }}">
                                        {{ $u->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>

                                {{-- Hapus --}}
                                <form method="POST" action="{{ route('admin.manajemen-pengguna.hapus', $u) }}" class="inline"
                                      onsubmit="return confirm('Hapus akun {{ addslashes($u->name) }}? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="text-xs font-bold text-red-600 border border-red-200 hover:bg-red-50 px-3 py-1.5 rounded-lg transition-colors">
                                        Hapus
                                    </button>
                                </form>
                                @else
                                <span class="text-xs text-gray-300 italic">Akun Anda</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-sm text-gray-400">Belum ada data pengguna.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-3 text-xs text-gray-400 border-t border-gray-100">
            <span>Menampilkan {{ $users->count() }} pengguna</span>
        </div>
    </div>
</div>

{{-- Modal Tambah Pengguna --}}
<div id="modal-tambah" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-6 max-h-screen overflow-y-auto">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-base font-bold text-gray-900">Tambah Pengguna</h3>
            <button onclick="document.getElementById('modal-tambah').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form action="{{ route('admin.manajemen-pengguna.store') }}" method="POST" class="space-y-4">
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

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor Telepon</label>
                <input type="tel" name="phone" value="{{ old('phone') }}"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Peran <span class="text-red-500">*</span></label>
                <select name="role" required
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Peran --</option>
                    <option value="Petugas Penanggulangan Bencana" {{ old('role') === 'Petugas Penanggulangan Bencana' ? 'selected' : '' }}>Petugas Penanggulangan Bencana</option>
                    <option value="Koordinator Relawan"            {{ old('role') === 'Koordinator Relawan' ? 'selected' : '' }}>Koordinator Relawan</option>
                    <option value="Masyarakat"                     {{ old('role') === 'Masyarakat' ? 'selected' : '' }}>Masyarakat</option>
                    <option value="Admin Sistem"                   {{ old('role') === 'Admin Sistem' ? 'selected' : '' }}>Admin Sistem</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Kata Sandi <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="password" name="password" id="modal-password" required minlength="6"
                           placeholder="Minimal 6 karakter"
                           class="w-full border border-gray-200 rounded-xl px-4 pr-12 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="button" onclick="toggleModalPassword()"
                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <svg id="modal-eye" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modal-tambah').classList.add('hidden')"
                        class="flex-1 border border-gray-200 text-gray-700 text-sm font-semibold py-2.5 rounded-xl hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-2.5 rounded-xl">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Ubah Pengguna --}}
<div id="modal-ubah" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-base font-bold text-gray-900">Ubah Pengguna</h3>
            <button onclick="document.getElementById('modal-ubah').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                <input type="text" id="ubah-nama" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Peran</label>
                <select id="ubah-peran" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Masyarakat</option>
                    <option>Petugas Penanggulangan Bencana</option>
                    <option>Koordinator Relawan</option>
                    <option>Admin Sistem</option>
                </select>
            </div>
        </div>
        <div class="flex gap-3 mt-6">
            <button onclick="document.getElementById('modal-ubah').classList.add('hidden')"
                    class="flex-1 border border-gray-200 text-gray-700 text-sm font-semibold py-2.5 rounded-xl">Batal</button>
            <button onclick="alert('Demo: Perubahan disimpan!');document.getElementById('modal-ubah').classList.add('hidden')"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-2.5 rounded-xl">Simpan Perubahan</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Buka modal jika ada validation error (setelah POST gagal)
@if($errors->any())
document.getElementById('modal-tambah').classList.remove('hidden');
@endif

function openUbah(nama, peran) {
    document.getElementById('ubah-nama').value = nama;
    document.getElementById('ubah-peran').value = peran;
    document.getElementById('modal-ubah').classList.remove('hidden');
}

function toggleModalPassword() {
    const f = document.getElementById('modal-password');
    f.type = f.type === 'password' ? 'text' : 'password';
}
</script>
@endpush