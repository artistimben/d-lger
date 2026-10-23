<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $truck->plate }} konum</title>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500&family=Oswald:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="login-wrap">
    <div class="card login-card">
        <div class="kicker">Şoför konumu</div>
        <h1>{{ $truck->plate }}</h1>
        <p class="muted">Konum izni verdikten sonra nokta firmaya düşer.</p>
        <p id="status">Hazır.</p>
        <button type="button" id="send">Konumu gönder</button>
    </div>
</div>
<script>
const token = document.querySelector('meta[name=csrf-token]').content;
document.getElementById('send').onclick = () => {
    const status = document.getElementById('status');
    if (!navigator.geolocation) { status.textContent = 'Tarayıcı konum desteklemiyor.'; return; }
    status.textContent = 'Konum alınıyor...';
    navigator.geolocation.getCurrentPosition(async (pos) => {
        const body = new FormData();
        body.append('_token', token);
        body.append('lat', pos.coords.latitude);
        body.append('lng', pos.coords.longitude);
        const res = await fetch(@json(route('location.store', $truck->share_token)), { method: 'POST', body });
        status.textContent = res.ok ? 'Konum gönderildi.' : 'Gönderilemedi.';
    }, () => status.textContent = 'Konum izni reddedildi.');
};
</script>
</body>
</html>
