<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['trip_id', 'category', 'title', 'amount', 'occurred_at', 'notes'])]
class TripExpense extends Model
{
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'occurred_at' => 'datetime',
        ];
    }

    public const CATEGORIES = [
        'komisyon' => 'Komisyon',
        'sofor' => 'Şoför ücreti',
        'yakit' => 'Yakıt',
        'otoyol' => 'Otoyol / köprü',
        'yeme_icme' => 'Yeme içme',
        'bakim' => 'Bakım / lastik',
        'diger' => 'Diğer',
    ];

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function categoryLabel(): string
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }
}
