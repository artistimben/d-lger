@extends('layouts.app')
@section('title', 'Kumanda')
@section('content')
<div class="topbar">
    <div>
        <div class="kicker">{{ $company->name }}</div>
        <h1>Ay sonu ciro</h1>
        <p class="muted">{{ now()->format('m.Y') }} · yolda {{ $activeTrips->count() }} sefer</p>
    </div>
    <a class="btn" href="{{ route('firma.trips.create') }}">Sefer başlat</a>
</div>
<div class="grid grid-4">
    <div class="card stat"><div class="label">Aylık gelir</div><div class="value">@tl($month['income'])</div></div>
    <div class="card stat"><div class="label">Aylık gider</div><div class="value">@tl($month['expense'])</div></div>
    <div class="card stat"><div class="label">Aylık net</div><div class="value {{ $month['net'] >= 0 ? 'net-pos' : 'net-neg' }}">@tl($month['net'])</div></div>
    <div class="card stat"><div class="label">Yıllık net</div><div class="value">@tl($year['net'])</div></div>
</div>
@if($month['best_trip'])
    <div class="card" style="margin-top:16px">
        <div class="kicker">Ayın en çok kazandıran seferi</div>
        <h2>{{ $month['best_trip']->routeLabel() }}</h2>
        <p class="muted">{{ $month['best_trip']->truck->plate ?? '' }} · Net @tl($month['best_trip_net'])</p>
    </div>
@endif
<div class="grid grid-2" style="margin-top:16px">
    <div class="card">
        <div class="split">
            <h2>Yoldaki seferler</h2>
            <a href="{{ route('firma.map') }}">Harita</a>
        </div>
        @forelse($activeTrips as $trip)
            <p>
                <a href="{{ route('firma.trips.show', $trip) }}">{{ $trip->routeLabel() }}</a>
                <br><span class="muted">{{ $trip->truck->plate }} · {{ $trip->truck->last_city ?: 'konum bekleniyor' }}</span>
            </p>
        @empty
            <p class="muted">Yolda sefer yok.</p>
        @endforelse
    </div>
    <div class="card">
        <h2>Muayene / bakım uyarısı</h2>
        @forelse($inspectionAlerts as $truck)
            <p>{{ $truck->plate }} · {{ $truck->inspection_due_at?->format('d.m.Y') }}</p>
        @empty
            <p class="muted">Yakın muayene yok.</p>
        @endforelse
    </div>
</div>
<div class="card" style="margin-top:16px">
    <h2>Son seferler</h2>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Güzergah</th><th>Tır</th><th>Ücret</th><th>Durum</th></tr></thead>
            <tbody>
            @foreach($recentTrips as $trip)
                <tr>
                    <td><a href="{{ route('firma.trips.show', $trip) }}">{{ $trip->routeLabel() }}</a></td>
                    <td>{{ $trip->truck->plate }}</td>
                    <td>@tl($trip->freight_fee)</td>
                    <td><span class="badge {{ $trip->status === 'yolda' ? 'badge-run' : 'badge-ok' }}">{{ $trip->status }}</span></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
