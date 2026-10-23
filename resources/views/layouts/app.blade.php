<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#12110f">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>@yield('title', 'Dülgeroğlu Filo')</title>
    <link rel="manifest" href="/manifest.json">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600&family=Oswald:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('head')
</head>
<body>
<div class="app">
    <aside class="sidebar" id="sidebar">
        <div class="split">
            <div class="brand">Dülgeroğlu<small>Filo kumanda</small></div>
            <button class="mobile-toggle" type="button" onclick="document.getElementById('sidebar').classList.toggle('is-open')">Menü</button>
        </div>
        <nav class="nav">
            @if(auth()->user()->isAdmin())
                <a class="{{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}" href="{{ route('admin.dashboard') }}">Genel bakış</a>
                <a class="{{ request()->routeIs('admin.companies.*') ? 'is-active' : '' }}" href="{{ route('admin.companies.index') }}">Firmalar</a>
                <a class="{{ request()->routeIs('admin.companies.create') ? 'is-active' : '' }}" href="{{ route('admin.companies.create') }}">Firma aç</a>
            @else
                <a class="{{ request()->routeIs('firma.dashboard') ? 'is-active' : '' }}" href="{{ route('firma.dashboard') }}">Kumanda</a>
                <a class="{{ request()->routeIs('firma.trucks.*') ? 'is-active' : '' }}" href="{{ route('firma.trucks.index') }}">Tırlar</a>
                <a class="{{ request()->routeIs('firma.drivers.*') ? 'is-active' : '' }}" href="{{ route('firma.drivers.index') }}">Şoförler</a>
                <a class="{{ request()->routeIs('firma.trips.*') ? 'is-active' : '' }}" href="{{ route('firma.trips.index') }}">Seferler</a>
                <a class="{{ request()->routeIs('firma.finance.*') ? 'is-active' : '' }}" href="{{ route('firma.finance.index') }}">Ekstra gelir / gider</a>
                <a class="{{ request()->routeIs('firma.reports') ? 'is-active' : '' }}" href="{{ route('firma.reports') }}">Mali rapor</a>
                <a class="{{ request()->routeIs('firma.map') ? 'is-active' : '' }}" href="{{ route('firma.map') }}">Canlı harita</a>
            @endif
        </nav>
        <div class="side-foot">
            <div>{{ auth()->user()->name }}</div>
            <div class="muted">{{ auth()->user()->isAdmin() ? 'Yönetici' : auth()->user()->company?->name }}</div>
            <form method="post" action="{{ route('logout') }}" style="margin-top:10px">
                @csrf
                <button class="ghost" type="submit">Çıkış</button>
            </form>
        </div>
    </aside>
    <main class="main">
        @if(session('ok'))
            <div class="flash">{{ session('ok') }}</div>
        @endif
        @if($errors->any())
            <div class="errors">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        @yield('content')
    </main>
</div>
<script>
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js').catch(() => {});
}
</script>
@stack('scripts')
</body>
</html>
