<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'regency_code',
        'name',
        'type',
        'province',
        'lat',
        'lon',
    ];

    protected $table = 'cities';

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'city_id');
    }
}
