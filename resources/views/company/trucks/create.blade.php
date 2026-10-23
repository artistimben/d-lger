@extends('layouts.app')
@section('title', 'Tır ekle')
@section('content')
<div class="topbar"><div class="kicker">Filo</div><h1>Yeni tır</h1></div>
<div class="card" style="max-width:720px">
    <form method="post" action="{{ route('firma.trucks.store') }}">
        @csrf
        @include('company.trucks.form')
        <button type="submit">Kaydet</button>
    </form>
</div>
@endsection
