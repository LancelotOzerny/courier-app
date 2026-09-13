<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LockerCell extends Model
{
    use HasFactory;

    protected $fillable = ['parcel_locker_id', 'number'];

    public function parcelLocker(): BelongsTo
    {
        return $this->belongsTo(ParcelLocker::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_cells')->withTimestamps();
    }
}
