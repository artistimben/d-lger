@extends('layouts.app')
@section('title', 'Tırlar')
@section('content')
<div class="topbar">
    <div>
        <div class="kicker">Filo</div>
        <h1>Tır kayıtları</h1>
    </div>
    <a class="btn" href="{{ route('firma.trucks.create') }}">Tır ekle</a>
</div>
<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Plaka</th><th>Araç</th><th>Durum</th><th>Son konum</th><th>Sefer</th><th></th></tr></thead>
            <tbody>
            @foreach($trucks as $truck)
                <tr>
                    <td><a href="{{ route('firma.trucks.show', $truck) }}">{{ $truck->plate }}</a></td>
                    <td>{{ $truck->brand }} {{ $truck->model }}</td>
                    <td>{{ $truck->status }}</td>
                    <td>{{ $truck->last_city ?: '—' }}<br><span class="muted">{{ $truck->last_located_at?->diffForHumans() }}</span></td>
                    <td>{{ $truck->trips_count }}</td>
                    <td><a class="btn ghost" href="{{ route('firma.trucks.edit', $truck) }}">Düzenle</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
