<?php

namespace App\Models;

use App\Models\Place;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    /** @use HasFactory<\Database\Factories\ReservationFactory> */
    use HasFactory;
    protected $guarded=[];

    public function place(){
        return $this->belongsTo(Place::class , 'place_id');
    }
}
