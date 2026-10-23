@php $trip = $trip ?? null; @endphp
<div class="grid grid-2">
    <div>
        <label>Tır</label>
        <select name="truck_id" required>
            @foreach($trucks as $truck)
                <option value="{{ $truck->id }}" @selected(old('truck_id', $trip->truck_id ?? '') == $truck->id)>{{ $truck->plate }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label>Şoför</label>
        <select name="driver_id">
            <option value="">Seçilmedi</option>
            @foreach($drivers as $driver)
                <option value="{{ $driver->id }}" @selected(old('driver_id', $trip->driver_id ?? '') == $driver->id)>{{ $driver->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label>Kalkış</label>
        <input name="origin" value="{{ old('origin', $trip->origin ?? '') }}" required placeholder="Hatay">
    </div>
    <div>
        <label>Varış</label>
        <input name="destination" value="{{ old('destination', $trip->destination ?? '') }}" required placeholder="İstanbul">
    </div>
    <div>
        <label>Müşteri</label>
        <input name="customer" value="{{ old('customer', $trip->customer ?? '') }}">
    </div>
    <div>
        <label>Yük</label>
        <input name="cargo" value="{{ old('cargo', $trip->cargo ?? '') }}">
    </div>
    <div>
        <label>Nakliye ücreti (₺)</label>
        <input type="number" step="0.01" name="freight_fee" value="{{ old('freight_fee', $trip->freight_fee ?? '') }}" required>
    </div>
    <div>
        <label>Mesafe (km)</label>
        <input type="number" name="distance_km" value="{{ old('distance_km', $trip->distance_km ?? '') }}">
    </div>
    <div>
        <label>Durum</label>
        <select name="status">
            @foreach(['planlandi'=>'Planlandı','yolda'=>'Yolda','tamamlandi'=>'Tamamlandı'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $trip->status ?? 'yolda') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label>Başlangıç</label>
        <input type="datetime-local" name="started_at" value="{{ old('started_at', optional($trip->started_at ?? now())->format('Y-m-d\\TH:i')) }}" required>
    </div>
</div>
<label>Not</label>
<textarea name="notes">{{ old('notes', $trip->notes ?? '') }}</textarea>
