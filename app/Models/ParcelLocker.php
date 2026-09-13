<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ParcelLocker extends Model
{
    use HasFactory;

    protected $fillable = ['number', 'address'];

    public function cells(): HasMany
    {
        return $this->hasMany(LockerCell::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
