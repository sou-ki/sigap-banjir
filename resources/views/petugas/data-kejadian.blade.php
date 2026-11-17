@extends('layouts.petugas')
@section('title', 'Data Kejadian Banjir')

@section('content')
<div class="p-5">
    <div class="mb-5">
        <h2 class="text-xl font-extrabold text-gray-900">Data Kejadian Banjir</h2>
        <p class="text-sm text-gray-500">Kejadian terverifikasi dan status penanganannya.</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-100 flex items-center gap-3">
            <div class="relative flex-1 max-w-xs">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-gray-400 absolute left-2.5 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" placeholder="Cari kejadian..." class="text-xs border border-gray-200 rounded-lg pl-8 pr-3 py-2 w-full focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>
        </div>

        <div class="grid gap-2 px-4 py-2.5 bg-gray-50 border-b border-gray-100 text-xs font-bold text-gray-500 uppercase tracking-wide" style="grid-template-columns:50px 2fr 1fr 1fr 1.2fr 1.2fr 100px">
            <div>No.</div><div>Kejadian</div><div>Bahaya</div><div>Estimasi</div><div>Penanganan</div><div>Perbarui</div><div>Aksi</div>
        </div>

        @php $kejadian = [
            ['no'=>'LPR-2610-0001','title'=>'Jalan Perdagangan terendam setinggi paha','loc'=>'Mon Geudong, 24 Okt 2026, 04:55','level'=>'red','est'=>'Lebih dari 100 cm','status'=>'Dalam Penanganan','new'=>'Dalam Penanganan'],
            ['no'=>'LPR-2610-0002','title'=>'Genangan di depan pasar Keude Aceh','loc'=>'Keude Aceh, 24 Okt 2026, 06:05','level'=>'orange','est'=>'30–60 cm','status'=>'Belum Ditangani','new'=>'Belum Ditangani'],
            ['no'=>'LPR-2610-0003','title'=>'Air sungai meluap ke permukiman Hagu Selatan','loc'=>'Hagu Selatan, 24 Okt 2026, 04:55','level'=>'red','est'=>'61–100 cm','status'=>'Dalam Penanganan','new'=>'Dalam Penanganan'],
            ['no'=>'LPR-2610-0008','title'=>'Banjir di Cunda','loc'=>'Cunda, 23 Okt 2026, 22:15','level'=>'orange','est'=>'30–60 cm','status'=>'Selesai','new'=>'Selesai'],
            ['no'=>'LPR-2610-0010','title'=>'Air masuk ke SD di Kuta Blang','loc'=>'Kuta Blang, 24 Okt 2026, 06:30','level'=>'orange','est'=>'30–60 cm','status'=>'Dalam Penanganan','new'=>'Dalam Penanganan'],
            ['no'=>'LPR-2610-0012','title'=>'Banjir di Banda Sakti dekat GOR','loc'=>'Banda Sakti, 22 Okt 2026, 20:10','level'=>'yellow','est'=>'Kurang dari 30 cm','status'=>'Selesai','new'=>'Selesai'],
        ];
        $lc = ['red'=>'bg-red-100 text-red-700','orange'=>'bg-orange-100 text-orange-700','yellow'=>'bg-yellow-100 text-yellow-700'];
        $sc = ['Dalam Penanganan'=>'bg-blue-100 text-blue-700','Belum Ditangani'=>'bg-gray-100 text-gray-600','Selesai'=>'bg-green-100 text-green-700'];
        $statuses = ['Dalam Penanganan','Belum Ditangani','Selesai'];
        @endphp

        <div class="divide-y divide-gray-50" id="kejadian-tbody">
            @foreach($kejadian as $i => $k)
            <div class="grid gap-2 px-4 py-3 text-sm items-center" style="grid-template-columns:50px 2fr 1fr 1fr 1.2fr 1.2fr 100px">
                <span class="text-xs font-mono text-gray-500">{{ $loop->iteration }}</span>
                <div>
                    <p class="text-xs font-semibold text-gray-900">{{ $k['title'] }}</p>
                    <p class="text-xs text-gray-400">{{ $k['loc'] }}</p>
                </div>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full w-fit {{ $lc[$k['level']] }}">{{ ['red'=>'Bahaya Tinggi','orange'=>'Bahaya Sedang','yellow'=>'Bahaya Rendah'][$k['level']] }}</span>
                <span class="text-xs text-gray-600">{{ $k['est'] }}</span>
                <span class="text-xs font-medium px-2 py-0.5 rounded-full w-fit {{ $sc[$k['status']] }}">{{ $k['status'] }}</span>
                {{-- Inline dropdown --}}
                <div class="relative">
                    <select onchange="updateStatus(this)" data-current="{{ $k['status'] }}" class="text-xs border border-gray-200 rounded-lg px-2 py-1.5 bg-white w-full focus:outline-none focus:ring-1 focus:ring-blue-500">
                        @foreach($statuses as $st)
                        <option {{ $st===$k['status']?'selected':'' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>
                <span class="text-xs text-gray-400">{{ $k['no'] }}</span>
            </div>
            @endforeach
        </div>
        <div class="px-4 py-3 text-xs text-gray-400 border-t border-gray-100 flex items-center justify-between">
            <span>Menampilkan 6 dari 6 data.</span>
            <div class="flex gap-1"><button class="w-6 h-6 border border-gray-200 rounded text-gray-500 text-xs">1</button></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateStatus(sel) {
    const val = sel.value;
    const colors = {'Dalam Penanganan':'bg-blue-100 text-blue-700','Belum Ditangani':'bg-gray-100 text-gray-600','Selesai':'bg-green-100 text-green-700'};
    sel.setAttribute('data-current', val);
}
</script>
@endpush
