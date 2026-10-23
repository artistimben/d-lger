@extends('layouts.app')
@section('title', 'Firma aç')
@section('content')
<div class="topbar">
    <div>
        <div class="kicker">Yönetici</div>
        <h1>Yeni firma hesabı</h1>
    </div>
</div>
<div class="card" style="max-width:720px">
    <form method="post" action="{{ route('admin.companies.store') }}">
        @csrf
        <div class="grid grid-2">
            <div>
                <label>Firma adı</label>
                <input name="name" value="{{ old('name') }}" required>
            </div>
            <div>
                <label>Vergi no</label>
                <input name="tax_number" value="{{ old('tax_number') }}">
            </div>
            <div>
                <label>Telefon</label>
                <input name="phone" value="{{ old('phone') }}">
            </div>
            <div>
                <label>Şehir</label>
                <input name="city" value="{{ old('city') }}">
            </div>
        </div>
        <label>Adres</label>
        <input name="address" value="{{ old('address') }}">
        <h2 style="margin:8px 0 12px">Giriş hesabı</h2>
        <div class="grid grid-2">
            <div>
                <label>Yetkili adı</label>
                <input name="user_name" value="{{ old('user_name') }}" required>
            </div>
            <div>
                <label>E-posta</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>
        </div>
        <label>Şifre</label>
        <input type="password" name="password" required>
        <button type="submit">Hesabı oluştur</button>
    </form>
</div>
@endsection
