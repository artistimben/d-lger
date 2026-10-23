@extends('layouts.app')
@section('title', 'Firmalar')
@section('content')
<div class="topbar">
    <div>
        <div class="kicker">Yönetici</div>
        <h1>Firma hesapları</h1>
    </div>
    <a class="btn" href="{{ route('admin.companies.create') }}">Firma oluştur</a>
</div>
<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Firma</th><th>Şehir</th><th>Giriş</th><th>Durum</th><th></th></tr></thead>
            <tbody>
            @foreach($companies as $company)
                <tr>
                    <td>{{ $company->name }}</td>
                    <td>{{ $company->city }}</td>
                    <td>{{ $company->users->pluck('email')->join(', ') }}</td>
                    <td>
                        <span class="badge {{ $company->is_active ? 'badge-ok' : 'badge-off' }}">
                            {{ $company->is_active ? 'Aktif' : 'Pasif' }}
                        </span>
                    </td>
                    <td class="actions">
                        <a class="btn ghost" href="{{ route('admin.companies.show', $company) }}">Detay</a>
                        <a class="btn ghost" href="{{ route('admin.companies.edit', $company) }}">Düzenle</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
