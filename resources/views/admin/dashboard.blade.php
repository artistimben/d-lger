@extends('layouts.app')
@section('title', 'Yönetici')
@section('content')
<div class="topbar">
    <div>
        <div class="kicker">Yönetici</div>
        <h1>Filo ağı</h1>
    </div>
    <a class="btn" href="{{ route('admin.companies.create') }}">Yeni firma hesabı</a>
</div>
<div class="grid grid-4">
    <div class="card stat"><div class="label">Firma</div><div class="value">{{ $companyCount }}</div></div>
    <div class="card stat"><div class="label">Firma hesabı</div><div class="value">{{ $userCount }}</div></div>
    <div class="card stat"><div class="label">Tır</div><div class="value">{{ $truckCount }}</div></div>
    <div class="card stat"><div class="label">Toplam sefer</div><div class="value">{{ $tripCount }}</div></div>
</div>
<div class="card" style="margin-top:16px">
    <h2>Bu ay firma ciroları</h2>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Firma</th><th>Tır</th><th>Sefer</th><th>Gelir</th><th>Net</th></tr></thead>
            <tbody>
            @forelse($summaries as $row)
                <tr>
                    <td><a href="{{ route('admin.companies.show', $row['company']) }}">{{ $row['company']->name }}</a></td>
                    <td>{{ $row['company']->trucks_count }}</td>
                    <td>{{ $row['trips'] }}</td>
                    <td>@tl($row['income'])</td>
                    <td class="{{ $row['net'] >= 0 ? 'net-pos' : 'net-neg' }}">@tl($row['net'])</td>
                </tr>
            @empty
                <tr><td colspan="5">Henüz firma yok.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
