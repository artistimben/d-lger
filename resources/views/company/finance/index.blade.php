@extends('layouts.app')
@section('title', 'Finans')
@section('content')
<div class="topbar">
    <div>
        <div class="kicker">Ciro dışı</div>
        <h1>Ekstra gelir ve gider</h1>
        <p class="muted">Sefer dışı komisyon, ofis, sigorta, parça satışı gibi kalemler burada toplanır.</p>
    </div>
</div>
<div class="grid grid-2">
    <div class="card">
        <h2>Ekstra gelir</h2>
        <form method="post" action="{{ route('firma.finance.income.store') }}">
            @csrf
            <label>Başlık</label>
            <input name="title" required>
            <label>Tutar</label>
            <input type="number" step="0.01" name="amount" required>
            <label>Tarih</label>
            <input type="date" name="occurred_on" value="{{ now()->toDateString() }}" required>
            <button type="submit">Gelir ekle</button>
        </form>
        <table style="margin-top:16px">
            @foreach($incomes as $income)
                <tr>
                    <td>{{ $income->title }}<br><span class="muted">{{ $income->occurred_on->format('d.m.Y') }}</span></td>
                    <td>@tl($income->amount)</td>
                    <td>
                        <form method="post" action="{{ route('firma.finance.income.destroy', $income) }}">
                            @csrf @method('DELETE')
                            <button class="ghost" type="submit">Sil</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="card">
        <h2>Ekstra gider</h2>
        <form method="post" action="{{ route('firma.finance.expense.store') }}">
            @csrf
            <label>Tür</label>
            <select name="category">
                @foreach($categories as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
            <label>Başlık</label>
            <input name="title" required placeholder="Aylık kasko">
            <label>Tutar</label>
            <input type="number" step="0.01" name="amount" required>
            <label>Tarih</label>
            <input type="date" name="occurred_on" value="{{ now()->toDateString() }}" required>
            <button type="submit">Gider ekle</button>
        </form>
        <table style="margin-top:16px">
            @foreach($expenses as $expense)
                <tr>
                    <td>{{ $expense->title }}<br><span class="muted">{{ $expense->categoryLabel() }}</span></td>
                    <td>@tl($expense->amount)</td>
                    <td>
                        <form method="post" action="{{ route('firma.finance.expense.destroy', $expense) }}">
                            @csrf @method('DELETE')
                            <button class="ghost" type="submit">Sil</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection
