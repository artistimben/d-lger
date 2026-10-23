@php $truck = $truck ?? null; @endphp
<div class="grid grid-2">
    <div>
        <label>Plaka</label>
        <input name="plate" value="{{ old('plate', $truck->plate ?? '') }}" required>
    </div>
    <div>
        <label>Durum</label>
        <select name="status">
            @foreach(['aktif'=>'Aktif','bakim'=>'Bakımda','pasif'=>'Pasif'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $truck->status ?? 'aktif') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label>Marka</label>
        <input name="brand" value="{{ old('brand', $truck->brand ?? '') }}">
    </div>
    <div>
        <label>Model</label>
        <input name="model" value="{{ old('model', $truck->model ?? '') }}">
    </div>
    <div>
        <label>Yıl</label>
        <input type="number" name="year" value="{{ old('year', $truck->year ?? '') }}">
    </div>
    <div>
        <label>Kapasite (kg)</label>
        <input type="number" name="capacity_kg" value="{{ old('capacity_kg', $truck->capacity_kg ?? '') }}">
    </div>
</div>
<label>Muayene tarihi</label>
<input type="date" name="inspection_due_at" value="{{ old('inspection_due_at', optional($truck->inspection_due_at ?? null)?->format('Y-m-d')) }}">
<label>Not</label>
<textarea name="notes">{{ old('notes', $truck->notes ?? '') }}</textarea>
