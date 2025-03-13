<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Parking;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index(){
        $parkingNumber = Parking::count(); 
        
        $parkingWithplaces = Parking::select('name')->withCount('places')->get(); 

        $totalPlaces = Place::count(); 

        $placeswithReservations= Place::select('number')->withCount('reservations')->get(); 

        $mostReservedPlace = DB::table('places p')
                                ->join('reservations r','r.place_id' , 'p.id' )
                                ->select('p.number' , DB::raw('Count(r.id) as total_reservs group by p.id'))
                                ->where('total_reservs' , DB::raw('Max(total_reservs)'))
                                ->get();
        $mostReservedPlace = DB::table('places as p')
                                ->join('reservations as r', 'r.place_id', '=', 'p.id')
                                ->select('p.number', DB::raw('COUNT(r.id) as total_reservs'))
                                ->groupBy('p.id', 'p.number')
                                ->havingRaw('COUNT(r.id) = (
                                    SELECT MAX(res_count) FROM (
                                        SELECT COUNT(r2.id) as res_count 
                                        FROM reservations r2 
                                        GROUP BY r2.place_id
                                    ) as subquery
                                )')
                                ->get();


        // {{$recette->comments_count}}
    }
}
