@extends('layouts.app')
@section('title', $truck->plate)
@section('content')
<div class="topbar">
    <div>
        <div class="kicker">Tır</div>
        <h1>{{ $truck->plate }}</h1>
        <p class="muted">{{ $truck->brand }} {{ $truck->model }} · {{ $truck->last_city ?: 'Konum yok' }}</p>
    </div>
    <div class="actions">
        <a class="btn ghost" href="{{ route('firma.trucks.edit', $truck) }}">Düzenle</a>
        <form method="post" action="{{ route('firma.trucks.destroy', $truck) }}" onsubmit="return confirm('Tır silinsin mi?')">
            @csrf @method('DELETE')
            <button class="danger" type="submit">Sil</button>
        </form>
    </div>
</div>
<div class="grid grid-2">
    <div class="card">
        <h2>Şoför konum linki</h2>
        <p class="muted">Bu bağlantıyı şoför telefonuna gönderin. Telefon konumunu panele basar.</p>
        <input readonly value="{{ route('location.show', $truck->share_token) }}">
        <form method="post" action="{{ route('firma.trucks.ping', $truck) }}">
            @csrf
            <h3 style="margin:12px 0">Manuel konum</h3>
            <div class="grid grid-2">
                <div><label>Enlem</label><input name="lat" required></div>
                <div><label>Boylam</label><input name="lng" required></div>
            </div>
            <label>Şehir / nokta</label>
            <input name="city">
            <button type="submit">Konumu yaz</button>
        </form>
    </div>
    <div class="card">
        <h2>Sefer geçmişi</h2>
        @foreach($truck->trips as $trip)
            <p><a href="{{ route('firma.trips.show', $trip) }}">{{ $trip->routeLabel() }}</a> · @tl($trip->freight_fee)</p>
        @endforeach
    </div>
</div>
@endsection
