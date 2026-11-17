@extends('layouts.koordinator')
@section('title', 'Ketersediaan Relawan')

@section('content')
<div class="p-5">
    <div class="mb-5">
        <h2 class="text-xl font-extrabold text-gray-900">Ketersediaan Relawan</h2>
        <p class="text-sm text-gray-500">Tinjau ketersediaan setiap relawan yang tidak sedang bertugas.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @php $relawan = [
            ['Muhammad Iqbal','Mon Geudong',['Evakuasi','Transportasi'],'Bertugas','Sedang bertugas — status berubah otomatis setelah penugasan selesai.','blue'],
            ['Nurul Azirah','Kuta Blang',['Pertolongan Pertama','Evakuasi'],'Tersedia',null,'teal'],
            ['Zulkifli','Banda Sakti',['Evakuasi','Logistik'],'Bertugas','Sedang bertugas — status berubah otomatis setelah penugasan selesai.','blue'],
            ['Cut Meutia','Hagu Selatan',['Pertolongan Pertama'],'Tersedia',null,'teal'],
            ['Rahmat Hidayat','Uteunkot',['Transportasi','Logistik'],'Tersedia',null,'teal'],
            ['Fitriani','Pusong',['Pendataan Lapangan','Komunikasi'],'Tersedia',null,'teal'],
            ['Teuku Ramli','Lancang Garam',['Evakuasi','Pertolongan Pertama'],'Tersedia',null,'teal'],
            ['Dewi Safitri','Batuphat',['Logistik','Pendataan Lapangan'],'Tidak Tersedia',null,'gray'],
            ['Alhan','Dang Pulo',['Komunikasi','Transportasi'],'Tersedia',null,'teal'],
            ['Mawaddah','Cunda',['Pertolongan Pertama','Pendataan Lapangan'],'Tersedia',null,'teal'],
            ['Hendra Saputra','Hagu Selatan',['Evakuasi','Transportasi'],'Tersedia',null,'teal'],
            ['Putri Maharani','Ujong Blang',['Logistik','Komunikasi'],'Tidak Tersedia',null,'gray'],
        ]; @endphp
        @foreach($relawan as $r)
        @php $sc=['teal'=>'bg-teal-100 text-teal-700','blue'=>'bg-blue-100 text-blue-700','gray'=>'bg-gray-100 text-gray-500']; @endphp
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
            <div class="flex items-start justify-between mb-2">
                <div>
                    <p class="font-semibold text-gray-900 text-sm">{{ $r[0] }}</p>
                    <p class="text-xs text-gray-400">{{ $r[1] }}</p>
                </div>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $sc[$r[5]] }}">{{ $r[2] }}</span>
            </div>
            <div class="flex flex-wrap gap-1 mb-3">
                @foreach($r[2] as $k)
                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">{{ $k }}</span>
                @endforeach
            </div>
            @if($r[3])
            <p class="text-xs text-{{ $r[5] === 'blue' ? 'blue' : 'gray' }}-500 bg-{{ $r[5] === 'blue' ? 'blue' : 'gray' }}-50 rounded-lg px-3 py-1.5 mb-3">{{ $r[3] }}</p>
            @endif
            <div class="flex gap-2">
                @if($r[2] === 'Tersedia')
                <button class="text-xs font-semibold text-teal-700 border border-teal-200 bg-teal-50 hover:bg-teal-100 px-3 py-1.5 rounded-lg">Tandai Tidak Tersedia</button>
                @elseif($r[2] === 'Tidak Tersedia')
                <button class="text-xs font-semibold text-teal-700 border border-teal-200 bg-teal-50 hover:bg-teal-100 px-3 py-1.5 rounded-lg">Tandai Tersedia</button>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
