@extends('layouts.app')
@section('title', 'Şoförler')
@section('content')
<div class="topbar">
    <div><div class="kicker">Kadro</div><h1>Şoförler</h1></div>
    <a class="btn" href="{{ route('firma.drivers.create') }}">Şoför ekle</a>
</div>
<div class="card">
    <table>
        <thead><tr><th>Ad</th><th>Telefon</th><th>Ehliyet</th><th>Varsayılan ücret</th><th></th></tr></thead>
        <tbody>
        @foreach($drivers as $driver)
            <tr>
                <td>{{ $driver->name }}</td>
                <td>{{ $driver->phone }}</td>
                <td>{{ $driver->license_no }}</td>
                <td>@tl($driver->default_wage)</td>
                <td><a class="btn ghost" href="{{ route('firma.drivers.edit', $driver) }}">Düzenle</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
