@extends('layouts.admin')
@section('title', 'Peran & Hak Akses')

@section('content')
<div class="p-6">
    <div class="mb-5">
        <h2 class="text-xl font-extrabold text-gray-900">Peran & Hak Akses</h2>
        <p class="text-sm text-gray-500">Matriks izin setiap peran pada sistem.</p>
    </div>

    {{-- Matriks izin --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide w-56">Izin</th>
                        @foreach(['Admin Sistem','Petugas Penanggulangan Bencana','Koordinator Relawan','Masyarakat'] as $r)
                        <th class="text-center px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide">{{ $r }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @php $permissions = [
                        ['Mengirim laporan banjir',         false, false, false, true ],
                        ['Meminta evakuasi',                 false, false, false, true ],
                        ['Melihat peta banjir',              true,  true,  true,  true ],
                        ['Memverifikasi laporan',            false, true,  false, false],
                        ['Mengelola kondisi jalan',          false, true,  false, false],
                        ['Mengelola lokasi pengungsian',     false, true,  false, false],
                        ['Mengelola permintaan evakuasi',    false, true,  false, false],
                        ['Mengelola data relawan',           false, false, true,  false],
                        ['Mengalokasikan relawan',           false, false, true,  false],
                        ['Mengelola pengguna',               true,  false, false, false],
                        ['Mengatur peran & izin',            true,  false, false, false],
                        ['Melihat log aktivitas',            true,  false, false, false],
                    ]; @endphp
                    @foreach($permissions as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 font-medium text-gray-800">{{ $p[0] }}</td>
                        @foreach([1,2,3,4] as $i)
                        <td class="px-4 py-3 text-center">
                            @if($p[$i])
                            <span class="inline-flex items-center gap-1 text-green-700 font-semibold text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                                Ya
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 text-gray-400 text-sm">
                                — Tidak
                            </span>
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Hak Akses Modul Logistik --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="text-sm font-bold text-gray-900">Hak Akses Modul Logistik</h3>
            <p class="text-xs text-gray-500 mt-0.5">Atur peran internal yang boleh melihat, menambahkan, mengubah, menyetujui, atau mengkonfirmasi data logistik. Setiap perubahan dicatat pada log aktivitas.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide">Modul</th>
                        <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide">Peran</th>
                        @foreach(['Melihat','Menambah','Mengubah','Menyetujui','Mengkonfirmasi'] as $h)
                        <th class="text-center px-3 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @php $modules = [
                        ['Stok Bantuan','Petugas Penanggulangan Bencana',true,true,true,false,false],
                        ['','Koordinator Relawan',true,true,false,false,false],
                        ['Kebutuhan Logistik','Petugas Penanggulangan Bencana',true,true,true,true,false],
                        ['','Koordinator Relawan',true,true,true,false,false],
                        ['Alokasi Bantuan','Petugas Penanggulangan Bencana',true,true,true,true,false],
                        ['','Koordinator Relawan',true,true,false,false,false],
                        ['Penyaluran Bantuan','Petugas Penanggulangan Bencana',true,true,true,false,true],
                        ['','Koordinator Relawan',true,false,true,false,false],
                        ['Konfirmasi Penerimaan','Petugas Penanggulangan Bencana',true,true,false,false,true],
                        ['','Koordinator Relawan',true,true,false,false,false],
                    ]; @endphp
                    @foreach($modules as $m)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 font-semibold text-gray-800">{{ $m[0] }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $m[1] }}</td>
                        @foreach([2,3,4,5,6] as $i)
                        <td class="px-3 py-3 text-center">
                            <input type="checkbox" {{ $m[$i] ? 'checked' : '' }}
                                   class="w-4 h-4 rounded border-gray-300 text-blue-600 cursor-pointer"
                                   onchange="alert('Demo: Perubahan dicatat pada log.')">
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-gray-100 space-y-2">
            <p class="text-xs text-gray-400">Masyarakat tidak memiliki akses ke modul logistik internal dan tidak dapat diubah. Pengaturan ini berlaku langsung pada halaman Petugas dan Koordinator.</p>
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 flex items-start gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                <div>
                    <p class="text-xs font-semibold text-blue-800">Prinsip akses</p>
                    <p class="text-xs text-blue-700 mt-0.5">Pendaftaran publik hanya membuat akun Masyarakat. Akun Petugas, Koordinator Relawan, dan Administrator dibuat oleh Administrator Sistem.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
