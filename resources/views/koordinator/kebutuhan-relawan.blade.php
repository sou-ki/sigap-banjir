@extends('layouts.koordinator')
@section('title', 'Kebutuhan Relawan')

@section('content')
<div class="p-5">
    <div class="mb-5">
        <h2 class="text-xl font-extrabold text-gray-900">Kebutuhan Relawan</h2>
        <p class="text-sm text-gray-500">Kebutuhan yang bersumber dari kejadian, evakuasi, dan pengungsian.</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        @foreach(['ID','Kebutuhan','Lokasi','Keahlian','Terpenuhi','Prioritas','Aksi'] as $h)
                        <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @php $rows = [
                        ['N-01','Evakuasi warga Hagu Selatan','Hagu Selatan','Evakuasi, Pertolongan Pertama','0/4','Prioritas Tinggi','red'],
                        ['N-02','Evakuasi benda Lancang Garam','Lancang Garam','Evakuasi, Pertolongan Pertama','0/3','Prioritas Tinggi','red'],
                        ['N-03','Distribusi logistik Aula Camat','Banda Sakti','Logistik, Transportasi','1/3','Prioritas Sedang','orange'],
                        ['N-04','Pencatatan korban terdampak Mon Geudong','Mon Geudong','Pendataan Lapangan, Komunikasi','1/2','Prioritas Sedang','orange'],
                        ['N-05','Dukungan dapur umum Muara Satu','Ujong Blang','Logistik','0/2','Prioritas Rendah','yellow'],
                    ]; @endphp
                    @foreach($rows as $r)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-xs font-mono text-gray-500">{{ $r[0] }}</td>
                        <td class="px-4 py-3">
                            <p class="font-semibold text-gray-900 text-sm">{{ $r[1] }}</p>
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-600 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-400 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
                            {{ $r[2] }}
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-600">{{ $r[3] }}</td>
                        <td class="px-4 py-3">
                            @php [$filled,$total] = explode('/',$r[4]); @endphp
                            <div class="flex items-center gap-2">
                                <div class="w-16 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-teal-500 rounded-full" style="width:{{ $total>0?round(($filled/$total)*100):0 }}%"></div>
                                </div>
                                <span class="text-xs text-gray-500">{{ $r[4] }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                                {{ $r[6]==='red' ? 'bg-red-100 text-red-700' : ($r[6]==='orange' ? 'bg-orange-100 text-orange-700' : 'bg-yellow-100 text-yellow-700') }}">
                                {{ $r[5] }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('koordinator.alokasi-relawan') }}" class="text-xs font-semibold text-white bg-teal-600 hover:bg-teal-700 px-3 py-1.5 rounded-lg transition-colors">Alokasikan</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 py-2.5 text-xs text-gray-400 border-t border-gray-100">Menampilkan 1–5 dari 5 data</div>
    </div>
</div>
@endsection
