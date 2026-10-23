@extends('layouts.app')
@section('title', $company->name)
@section('content')
<div class="topbar">
    <div>
        <div class="kicker">Firma</div>
        <h1>{{ $company->name }}</h1>
        <p class="muted">{{ $company->city }} · {{ $company->phone }} · {{ $company->tax_number }}</p>
    </div>
    <a class="btn" href="{{ route('admin.companies.edit', $company) }}">Düzenle</a>
</div>
<div class="grid grid-2">
    <div class="card">
        <h2>Hesaplar</h2>
        @foreach($company->users as $user)
            <p>{{ $user->name }}<br><span class="muted">{{ $user->email }}</span></p>
        @endforeach
    </div>
    <div class="card">
        <h2>Filo özeti</h2>
        <p>Tır: {{ $company->trucks->count() }}</p>
        <p>Şoför: {{ $company->drivers->count() }}</p>
    </div>
</div>
@endsection
