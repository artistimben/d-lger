@extends('layouts.app')
@section('title', 'Mali rapor')
@section('content')
<div class="topbar">
    <div>
        <div class="kicker">Rapor</div>
        <h1>Mali özet</h1>
    </div>
</div>
<form class="card" method="get" action="{{ route('firma.reports') }}">
    <div class="grid grid-3">
        <div>
            <label>Başlangıç</label>
            <input type="date" name="from" value="{{ $from->toDateString() }}">
        </div>
        <div>
            <label>Bitiş</label>
            <input type="date" name="to" value="{{ $to->toDateString() }}">
        </div>
        <div style="display:flex;align-items:end">
            <button type="submit">Aralığı hesapla</button>
        </div>
    </div>
</form>
<div class="grid grid-4" style="margin-top:16px">
    <div class="card stat"><div class="label">Seçilen net</div><div class="value">@tl($range['net'])</div></div>
    <div class="card stat"><div class="label">Aylık net</div><div class="value">@tl($month['net'])</div></div>
    <div class="card stat"><div class="label">Yıllık net</div><div class="value">@tl($year['net'])</div></div>
    <div class="card stat"><div class="label">Sefer sayısı</div><div class="value">{{ $range['trip_count'] }}</div></div>
</div>
<div class="grid grid-2" style="margin-top:16px">
    <div class="card">
        <h2>Seçilen aralık</h2>
        <p>Nakliye geliri: @tl($range['freight'])</p>
        <p>Ekstra gelir: @tl($range['extra_income'])</p>
        <p>Sefer masrafı: @tl($range['trip_expenses'])</p>
        <p>Ekstra gider: @tl($range['extra_expense'])</p>
        @if($range['best_trip'])
            <p>En kârlı sefer: {{ $range['best_trip']->routeLabel() }} · @tl($range['best_trip_net'])</p>
        @endif
    </div>
    <div class="card">
        <h2>Gider kırılımı</h2>
        @forelse($range['expense_by_category'] as $key => $amount)
            <p>{{ $categories[$key] ?? $key }} · @tl($amount)</p>
        @empty
            <p class="muted">Gider yok.</p>
        @endforelse
    </div>
</div>
<div class="card" style="margin-top:16px">
    <h2>Sefer dökümü</h2>
    <table>
        <thead><tr><th>Sefer</th><th>Gelir</th><th>Masraf</th><th>Net</th></tr></thead>
        <tbody>
        @foreach($range['trips'] as $trip)
            @php $e = $trip->expenses->sum('amount'); $n = $trip->freight_fee - $e; @endphp
            <tr>
                <td><a href="{{ route('firma.trips.show', $trip) }}">{{ $trip->routeLabel() }}</a></td>
                <td>@tl($trip->freight_fee)</td>
                <td>@tl($e)</td>
                <td>@tl($n)</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
