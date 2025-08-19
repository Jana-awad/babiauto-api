<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'booking_id',
        'amount',
        'payment_method',
        'status',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',    
        'status' => 'string',
    ];
    /**
     * Get the booking associated with the payment.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
    
}
