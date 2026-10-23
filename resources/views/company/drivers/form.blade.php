@php $driver = $driver ?? null; @endphp
<div class="grid grid-2">
    <div><label>Ad soyad</label><input name="name" value="{{ old('name', $driver->name ?? '') }}" required></div>
    <div><label>Telefon</label><input name="phone" value="{{ old('phone', $driver->phone ?? '') }}"></div>
    <div><label>Ehliyet no</label><input name="license_no" value="{{ old('license_no', $driver->license_no ?? '') }}"></div>
    <div><label>Ehliyet bitiş</label><input type="date" name="license_expires_at" value="{{ old('license_expires_at', optional($driver->license_expires_at ?? null)?->format('Y-m-d')) }}"></div>
</div>
<label>Varsayılan sefer ücreti</label>
<input type="number" step="0.01" name="default_wage" value="{{ old('default_wage', $driver->default_wage ?? '') }}">
<label style="display:flex;gap:8px;align-items:center;text-transform:none">
    <input type="checkbox" name="is_active" value="1" style="width:auto;margin:0" @checked(old('is_active', $driver->is_active ?? true))>
    Aktif
</label>
