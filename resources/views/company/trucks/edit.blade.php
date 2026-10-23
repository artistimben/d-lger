@extends('layouts.app')
@section('title', 'Tır düzenle')
@section('content')
<div class="topbar"><div class="kicker">Filo</div><h1>{{ $truck->plate }}</h1></div>
<div class="card" style="max-width:720px">
    <form method="post" action="{{ route('firma.trucks.update', $truck) }}">
        @csrf
        @method('PUT')
        @include('company.trucks.form')
        <button type="submit">Güncelle</button>
    </form>
</div>
@endsection
