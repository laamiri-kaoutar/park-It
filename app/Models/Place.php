<?php

namespace App\Models;

use App\Models\Parking;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Place extends Model
{
    /** @use HasFactory<\Database\Factories\PlaceFactory> */
    use HasFactory;
    protected $guarded=[];

    public function parking()
    {
        return $this->belongsTo(Parking::class , 'parking_id');
    }

    public function reservations(){
        return $this->hasMany(Reservation::class , 'place_id');
    }
}
