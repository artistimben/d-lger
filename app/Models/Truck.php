<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Fillable([
    'company_id', 'plate', 'brand', 'model', 'year', 'capacity_kg',
    'status', 'inspection_due_at', 'share_token', 'last_lat', 'last_lng',
    'last_city', 'last_located_at', 'notes',
])]
class Truck extends Model
{
    protected function casts(): array
    {
        return [
            'inspection_due_at' => 'date',
            'last_located_at' => 'datetime',
            'last_lat' => 'float',
            'last_lng' => 'float',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Truck $truck) {
            if (! $truck->share_token) {
                $truck->share_token = Str::random(32);
            }
        });
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }

    public function locationPings(): HasMany
    {
        return $this->hasMany(LocationPing::class);
    }

    public function activeTrip(): ?Trip
    {
        return $this->trips()->where('status', 'yolda')->latest('started_at')->first();
    }

    public function isInspectionDueSoon(): bool
    {
        if (! $this->inspection_due_at) {
            return false;
        }

        return $this->inspection_due_at->lte(now()->addDays(30));
    }
}
