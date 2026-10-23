@extends('layouts.app')
@section('title', $trip->routeLabel())
@section('content')
@php $exp = $trip->expenses->sum('amount'); $net = $trip->freight_fee - $exp; @endphp
<div class="topbar">
    <div>
        <div class="kicker">{{ $trip->started_at->format('d.m.Y H:i') }}</div>
        <h1>{{ $trip->routeLabel() }}</h1>
        <p class="muted">{{ $trip->truck->plate }} · {{ $trip->driver?->name }} · {{ $trip->customer }} · {{ $trip->cargo }}</p>
    </div>
    <div class="actions">
        <a class="btn ghost" href="{{ route('firma.trips.edit', $trip) }}">Düzenle</a>
        @if($trip->status !== 'tamamlandi')
            <form method="post" action="{{ route('firma.trips.complete', $trip) }}">
                @csrf
                <button type="submit">Seferi bitir</button>
            </form>
        @endif
    </div>
</div>
<div class="grid grid-3">
    <div class="card stat"><div class="label">Nakliye</div><div class="value">@tl($trip->freight_fee)</div></div>
    <div class="card stat"><div class="label">Masraflar</div><div class="value">@tl($exp)</div></div>
    <div class="card stat"><div class="label">Net</div><div class="value {{ $net >= 0 ? 'net-pos' : 'net-neg' }}">@tl($net)</div></div>
</div>
<p class="muted" style="margin:14px 0">Sefer yoldayken ve bittikten sonra masraf ekleyebilirsiniz: komisyon, şoför, yakıt, otoyol.</p>
<div class="grid grid-2">
    <div class="card">
        <h2>Masraf ekle</h2>
        <form method="post" action="{{ route('firma.trips.expenses.store', $trip) }}">
            @csrf
            <label>Tür</label>
            <select name="category">
                @foreach($categories as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
            <label>Başlık</label>
            <input name="title" required placeholder="İstanbul komisyon">
            <label>Tutar</label>
            <input type="number" step="0.01" name="amount" required>
            <label>Tarih</label>
            <input type="datetime-local" name="occurred_at" value="{{ now()->format('Y-m-d\\TH:i') }}" required>
            <label>Not</label>
            <textarea name="notes"></textarea>
            <button type="submit">Masrafı ekle</button>
        </form>
    </div>
    <div class="card">
        <h2>Masraf listesi</h2>
        <table>
            <thead><tr><th>Kalem</th><th>Tutar</th><th></th></tr></thead>
            <tbody>
            @forelse($trip->expenses as $expense)
                <tr>
                    <td>{{ $expense->title }}<br><span class="muted">{{ $expense->categoryLabel() }} · {{ $expense->occurred_at->format('d.m.Y') }}</span></td>
                    <td>@tl($expense->amount)</td>
                    <td>
                        <form method="post" action="{{ route('firma.trips.expenses.destroy', [$trip, $expense]) }}">
                            @csrf @method('DELETE')
                            <button class="ghost" type="submit">Sil</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3">Henüz masraf yok.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
