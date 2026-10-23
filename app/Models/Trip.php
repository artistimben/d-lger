<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'company_id', 'truck_id', 'driver_id', 'origin', 'destination',
    'customer', 'cargo', 'freight_fee', 'distance_km', 'status',
    'started_at', 'completed_at', 'notes',
])]
class Trip extends Model
{
    protected function casts(): array
    {
        return [
            'freight_fee' => 'decimal:2',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function truck(): BelongsTo
    {
        return $this->belongsTo(Truck::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(TripExpense::class);
    }

    public function routeLabel(): string
    {
        return $this->origin.' → '.$this->destination;
    }

    public function expenseTotal(): float
    {
        return (float) $this->expenses()->sum('amount');
    }

    public function netProfit(): float
    {
        return (float) $this->freight_fee - $this->expenseTotal();
    }
}
