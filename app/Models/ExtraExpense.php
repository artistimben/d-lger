<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['company_id', 'title', 'category', 'amount', 'occurred_on', 'notes'])]
class ExtraExpense extends Model
{
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'occurred_on' => 'date',
        ];
    }

    public const CATEGORIES = [
        'komisyon' => 'Komisyon',
        'sofor' => 'Şoför ücreti',
        'vergi' => 'Vergi / harç',
        'sigorta' => 'Sigorta',
        'kira' => 'Ofis / kira',
        'bakim' => 'Filo bakımı',
        'diger' => 'Diğer',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function categoryLabel(): string
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }
}
