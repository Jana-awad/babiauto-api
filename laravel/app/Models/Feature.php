<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
       
    ];  
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
   
    /**
     * The vehicles that have this feature.
     */
    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class, 'feature_vehicle'); 
    }
}
