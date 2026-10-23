<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Giriş · Dülgeroğlu Filo</title>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600&family=Oswald:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="manifest" href="/manifest.json">
</head>
<body>
<div class="login-wrap">
    <div class="card login-card">
        <div class="kicker">Nakliye operasyon</div>
        <h1 style="margin:8px 0 6px">Dülgeroğlu Filo</h1>
        <p class="muted">Firma hesapları yönetici tarafından açılır. Web ve masaüstü aynı panele bağlanır.</p>
        @if($errors->any())
            <div class="errors" style="margin-top:16px">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        <form method="post" action="{{ route('login') }}" style="margin-top:18px">
            @csrf
            <label>E-posta</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
            <label>Şifre</label>
            <input type="password" name="password" required>
            <label style="display:flex;align-items:center;gap:8px;text-transform:none;letter-spacing:0">
                <input type="checkbox" name="remember" value="1" style="width:auto;margin:0"> Beni hatırla
            </label>
            <button type="submit">Panele gir</button>
        </form>
        <p class="muted" style="margin-top:18px;font-size:.85rem">
            Demo yönetici: admin@dulgeroglu.com / password<br>
            Demo firma: firma@hataylo.com / password
        </p>
    </div>
</div>
</body>
</html>
