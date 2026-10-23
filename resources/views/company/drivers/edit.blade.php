@extends('layouts.app')
@section('title', 'Şoför düzenle')
@section('content')
<div class="topbar"><h1>{{ $driver->name }}</h1></div>
<div class="card" style="max-width:720px">
    <form method="post" action="{{ route('firma.drivers.update', $driver) }}">
        @csrf @method('PUT')
        @include('company.drivers.form')
        <button type="submit">Güncelle</button>
    </form>
</div>
@endsection
