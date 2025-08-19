<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'make',
        'model',
        'year',
        'type',
        'price_per_day',
        'status',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'year' => 'integer',
        'price_per_day' => 'decimal:2',
        'status' => 'string',
    ];
    /**
     * Get the bookings for the vehicle.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);

    }
    public function features()
    {
        return $this->belongsToMany(Feature::class,'feature_vehicle');
    
    }
}
