@extends('layouts.app')
@section('title', 'Seferler')
@section('content')
<div class="topbar">
    <div><div class="kicker">Operasyon</div><h1>Seferler</h1></div>
    <a class="btn" href="{{ route('firma.trips.create') }}">Sefer başlat</a>
</div>
<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Tarih</th><th>Güzergah</th><th>Tır / şoför</th><th>Nakliye</th><th>Masraf</th><th>Net</th><th>Durum</th></tr></thead>
            <tbody>
            @foreach($trips as $trip)
                @php $exp = $trip->expenses->sum('amount'); $net = $trip->freight_fee - $exp; @endphp
                <tr>
                    <td>{{ $trip->started_at->format('d.m.Y') }}</td>
                    <td><a href="{{ route('firma.trips.show', $trip) }}">{{ $trip->routeLabel() }}</a></td>
                    <td>{{ $trip->truck->plate }}<br><span class="muted">{{ $trip->driver?->name }}</span></td>
                    <td>@tl($trip->freight_fee)</td>
                    <td>@tl($exp)</td>
                    <td class="{{ $net >= 0 ? 'net-pos' : 'net-neg' }}">@tl($net)</td>
                    <td><span class="badge {{ $trip->status === 'yolda' ? 'badge-run' : 'badge-ok' }}">{{ $trip->status }}</span></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $trips->links() }}
</div>
@endsection
