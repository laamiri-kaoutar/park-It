<?php

namespace App\Models;

use App\Models\Place;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parking extends Model
{
    /** @use HasFactory<\Database\Factories\ParkingFactory> */
    protected $guarded= [];
    use HasFactory;

    public function places()
    {
        return $this->hasMany(Place::class , 'parking_id');
    }
}
