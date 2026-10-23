@extends('layouts.app')
@section('title', 'Firma düzenle')
@section('content')
<div class="topbar">
    <div>
        <div class="kicker">Yönetici</div>
        <h1>{{ $company->name }}</h1>
    </div>
</div>
@php $owner = $company->users->first(); @endphp
<div class="card" style="max-width:720px">
    <form method="post" action="{{ route('admin.companies.update', $company) }}">
        @csrf
        @method('PUT')
        <div class="grid grid-2">
            <div>
                <label>Firma adı</label>
                <input name="name" value="{{ old('name', $company->name) }}" required>
            </div>
            <div>
                <label>Vergi no</label>
                <input name="tax_number" value="{{ old('tax_number', $company->tax_number) }}">
            </div>
            <div>
                <label>Telefon</label>
                <input name="phone" value="{{ old('phone', $company->phone) }}">
            </div>
            <div>
                <label>Şehir</label>
                <input name="city" value="{{ old('city', $company->city) }}">
            </div>
        </div>
        <label>Adres</label>
        <input name="address" value="{{ old('address', $company->address) }}">
        <label style="display:flex;gap:8px;align-items:center;text-transform:none">
            <input type="checkbox" name="is_active" value="1" style="width:auto;margin:0" @checked(old('is_active', $company->is_active))>
            Aktif
        </label>
        <h2 style="margin:16px 0 12px">Giriş hesabı</h2>
        <div class="grid grid-2">
            <div>
                <label>Yetkili adı</label>
                <input name="user_name" value="{{ old('user_name', $owner?->name) }}" required>
            </div>
            <div>
                <label>E-posta</label>
                <input type="email" name="email" value="{{ old('email', $owner?->email) }}" required>
            </div>
        </div>
        <label>Yeni şifre (boş bırakılırsa değişmez)</label>
        <input type="password" name="password">
        <button type="submit">Kaydet</button>
    </form>
</div>
@endsection
