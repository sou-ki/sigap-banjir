<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SIGAP Banjir')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-900 antialiased min-h-screen">

<div class="flex min-h-screen">

    {{-- Left: Map background --}}
    <div class="hidden lg:flex flex-col flex-1 relative overflow-hidden">
        <div id="auth-map" class="absolute inset-0 z-0"></div>
        {{-- Dark overlay --}}
        <div class="absolute inset-0 z-10" style="background: linear-gradient(to top, rgba(10,25,47,0.85) 30%, rgba(10,25,47,0.35) 100%)"></div>
        {{-- Logo top-left --}}
        <div class="relative z-20 p-6">
            <a href="{{ route('home') }}" class="flex items-center gap-2 w-fit">
                <div class="w-10 h-10 rounded-full bg-blue-900 flex items-center justify-center shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    </svg>
                </div>
                <div class="leading-tight">
                    <div class="font-bold text-white text-sm leading-none">SIGAP</div>
                    <div class="font-bold text-blue-300 text-sm leading-none">BANJIR</div>
                </div>
            </a>
        </div>
        {{-- Bottom text --}}
        <div class="relative z-20 mt-auto p-8">
            <h2 class="text-2xl font-extrabold text-white leading-snug mb-3">
                Satu peta untuk laporan warga, jalur evakuasi, dan koordinasi relawan.
            </h2>
            <p class="text-sm text-blue-200">Sistem Informasi Geografis dan Koordinasi Respons Banjir Kota Lhokseumawe.</p>

            <p class="text-xs text-blue-300/70 mt-3">Prototipe Capstone — bukan layanan darurat resmi pemerintah.</p>
        </div>
    </div>

    {{-- Right: Form panel --}}
    <div class="w-full lg:w-[460px] xl:w-[500px] flex-shrink-0 flex flex-col overflow-y-auto">
        <div class="flex-1 flex flex-col justify-center px-8 py-10">
            @yield('form')
        </div>
    </div>

</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mapEl = document.getElementById('auth-map');
    if (!mapEl) return;
    const map = L.map('auth-map', { zoomControl: false, attributionControl: false, dragging: false, scrollWheelZoom: false, doubleClickZoom: false, boxZoom: false, keyboard: false }).setView([5.1801, 97.1500], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18 }).addTo(map);
    const pts = [
        [5.183, 97.148, '#dc2626', true], [5.178, 97.153, '#f97316', true],
        [5.175, 97.145, '#dc2626', true], [5.188, 97.152, '#eab308', false],
        [5.174, 97.158, '#f97316', true], [5.192, 97.162, '#dc2626', true],
    ];
    pts.forEach(function(p) {
        L.circleMarker([p[0], p[1]], { radius: 16, fillColor: p[2], color: p[2], weight: 2, fillOpacity: 0.3, opacity: 0.8 }).addTo(map);
        if (p[3]) {
            const ic = L.divIcon({ html: '<div style="width:16px;height:16px;background:' + p[2] + ';border-radius:50%;border:2px solid #fff;box-shadow:0 1px 4px rgba(0,0,0,.35)"></div>', className: '', iconSize: [16,16], iconAnchor: [8,8] });
            L.marker([p[0], p[1]], { icon: ic }).addTo(map);
        }
    });
    const shelterIc = L.divIcon({ html: '<div style="width:22px;height:22px;background:#1d4ed8;border-radius:50%;border:2px solid #fff;display:flex;align-items:center;justify-content:center;box-shadow:0 1px 4px rgba(0,0,0,.35)"><svg width="11" height="11" viewBox="0 0 24 24" fill="white"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg></div>', className: '', iconSize: [22,22], iconAnchor: [11,11] });
    [[5.182,97.142],[5.170,97.150],[5.195,97.165],[5.180,97.160],[5.173,97.138]].forEach(function(s){
        L.marker(s, { icon: shelterIc }).addTo(map);
    });
});
</script>
@stack('scripts')
</body>
</html>
