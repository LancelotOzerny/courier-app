<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'courier_id',
        'parcel_locker_id',
        'courier_created_at',
        'status',
    ];

    protected function casts(): array
    {
        return ['courier_created_at' => 'datetime'];
    }

    public function courier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'courier_id');
    }

    public function parcelLocker(): BelongsTo
    {
        return $this->belongsTo(ParcelLocker::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function lockerCells(): BelongsToMany
    {
        return $this->belongsToMany(LockerCell::class, 'order_cells')->withTimestamps();
    }
}
