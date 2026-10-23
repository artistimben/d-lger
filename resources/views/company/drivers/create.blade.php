@extends('layouts.app')
@section('title', 'Şoför ekle')
@section('content')
<div class="topbar"><h1>Yeni şoför</h1></div>
<div class="card" style="max-width:720px">
    <form method="post" action="{{ route('firma.drivers.store') }}">
        @csrf
        @include('company.drivers.form')
        <button type="submit">Kaydet</button>
    </form>
</div>
@endsection
