# Dülgeroğlu Filo

Tır firmaları için Laravel tabanlı sefer, masraf ve ciro yönetim paneli. Web tarayıcıda çalışır; masaüstünde PWA veya Electron penceresi olarak da açılır.

## Çalıştırma

```bash
php artisan migrate:fresh --seed
php artisan serve
```

Adres: http://127.0.0.1:8000

### Demo giriş

| Rol | E-posta | Şifre |
| --- | --- | --- |
| Yönetici | admin@dulgeroglu.com | password |
| Firma | firma@hataylo.com | password |

Yeni firma hesaplarını yalnızca yönetici oluşturur. Firmalar kendi kendine kayıt olamaz.

## Masaüstü

1. Sunucuyu `php artisan serve` ile açın.
2. Chrome / Edge ile panele girip **Uygulamayı yükle** deyin.
3. Ya da `desktop` klasöründe:

```bash
cd desktop
npm install
npm start
```

## Şoför konumu

Tır detay sayfasındaki paylaşım linkini şoföre gönderin. Telefon konum izni verdikten sonra haritada görünür.
