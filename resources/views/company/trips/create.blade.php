@extends('layouts.app')
@section('title', 'Sefer başlat')
@section('content')
<div class="topbar">
    <div>
        <div class="kicker">Sefer</div>
        <h1>Yeni sefer</h1>
        <p class="muted">Örnek: Hatay → İstanbul, nakliye 40.000 ₺, komisyon ve şoför ücreti aynı anda eklenebilir.</p>
    </div>
</div>
<div class="card" style="max-width:860px">
    <form method="post" action="{{ route('firma.trips.store') }}">
        @csrf
        @include('company.trips.form')
        <div class="grid grid-2">
            <div>
                <label>Komisyon (opsiyonel)</label>
                <input type="number" step="0.01" name="commission_amount" value="{{ old('commission_amount') }}" placeholder="2000">
            </div>
            <div>
                <label>Şoför ücreti (opsiyonel)</label>
                <input type="number" step="0.01" name="driver_wage" value="{{ old('driver_wage') }}">
            </div>
        </div>
        <button type="submit">Seferi başlat</button>
    </form>
</div>
@endsection
