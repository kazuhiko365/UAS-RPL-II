<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city',
        'latitude',
        'longitude',
        'price_per_hour',
        'rating',
        'image_url'
    ];

    // --- TAMBAHKAN KODE INI ---
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function sports()
    {
        return $this->belongsToMany(Sport::class, 'sport_venue');
    }
}