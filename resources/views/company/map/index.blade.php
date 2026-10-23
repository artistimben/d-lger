@extends('layouts.app')
@section('title', 'Harita')
@push('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
@endpush
@section('content')
<div class="topbar">
    <div>
        <div class="kicker">Canlı</div>
        <h1>Tır konumları</h1>
        <p class="muted">Son bildirilen noktalar. Şoför linki tır detay sayfasındadır.</p>
    </div>
</div>
<div class="card">
    <div id="map" class="map"></div>
</div>
<div class="card" style="margin-top:16px">
    <table>
        <thead><tr><th>Plaka</th><th>Nokta</th><th>Zaman</th><th>Sefer</th></tr></thead>
        <tbody>
        @foreach($trucks as $truck)
            <tr>
                <td>{{ $truck->plate }}</td>
                <td>{{ $truck->last_city ?: '—' }}</td>
                <td>{{ $truck->last_located_at?->diffForHumans() ?: 'konum yok' }}</td>
                <td>{{ $truck->trips->first()?->routeLabel() ?: 'boşta' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const trucks = @json($trucks->map(fn ($t) => [
    'plate' => $t->plate,
    'lat' => $t->last_lat,
    'lng' => $t->last_lng,
    'city' => $t->last_city,
    'trip' => optional($t->trips->first())->routeLabel(),
]));
const map = L.map('map').setView([39.0, 35.2], 6);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OSM' }).addTo(map);
const pts = [];
trucks.forEach(t => {
    if (!t.lat || !t.lng) return;
    pts.push([t.lat, t.lng]);
    L.marker([t.lat, t.lng]).addTo(map).bindPopup(`<b>${t.plate}</b><br>${t.city || ''}<br>${t.trip || ''}`);
});
if (pts.length) map.fitBounds(pts, { padding: [40, 40] });
</script>
@endpush
