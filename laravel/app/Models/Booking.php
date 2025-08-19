<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class booking extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'vehicle_id',
        'start_date',
        'end_date',
        'total_price',
        'status',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'total_price' => 'decimal:2',
        'status' => 'string',
    ];
    /**
     * Get the user that owns the booking.
     */
    public function user()
    {
        return $this->belongsTo(User::class);

    }
    /**
     * Get the vehicle that is booked.
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    public function insurance()
    {
        return $this->hasOne(Insurance::class);
    }
}
