<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id',
        'make',
        'model',
        'year',
        'color',
        'license_plate',
        'transmission',
        'fuel_type',
        'seats',
        'doors',
        'daily_rate',
        'country_id',
        'city_id',
        'status',
    ];

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function isAvailable()
    {
        return $this->status === 'available';
    }

    public function isRented()
    {
        return $this->status === 'rented';
    }
}