<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'booking_id',
        'type',
        'coverage',  
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'coverage' => 'decimal:2',
        'status' => 'string',
        'type' => 'string',
        'booking_id' => 'integer',
    ];
    /**
     * Get the booking associated with the insurance.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);    
    }
}
