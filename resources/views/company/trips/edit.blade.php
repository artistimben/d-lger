@extends('layouts.app')
@section('title', 'Sefer düzenle')
@section('content')
<div class="topbar"><h1>{{ $trip->routeLabel() }}</h1></div>
<div class="card" style="max-width:860px">
    <form method="post" action="{{ route('firma.trips.update', $trip) }}">
        @csrf @method('PUT')
        @include('company.trips.form')
        <button type="submit">Kaydet</button>
    </form>
</div>
@endsection
