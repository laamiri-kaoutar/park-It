<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Parking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class StatisticsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/statistics",
     *     summary="Get parking and reservation statistics",
     *     tags={"Statistics"},
     *     @OA\Response(
     *         response=200,
     *         description="Statistics retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="parkingNumber", type="integer", example=5),
     *             @OA\Property(
     *                 property="parkingWithplaces",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="name", type="string", example="Main Parking"),
     *                     @OA\Property(property="places_count", type="integer", example=20)
     *                 )
     *             ),
     *             @OA\Property(property="totalPlaces", type="integer", example=100),
     *             @OA\Property(
     *                 property="placeswithReservations",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="number", type="string", example="P1"),
     *                     @OA\Property(property="reservations_count", type="integer", example=5)
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="mostReservedPlace",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="number", type="string", example="P1"),
     *                     @OA\Property(property="total_reservs", type="integer", example=10)
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $parkingNumber = Parking::count();
        
        $parkingWithplaces = Parking::select('name')->withCount('places')->get();

        $totalPlaces = Place::count();

        $placeswithReservations = Place::select('number')->withCount('reservations')->get();

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

        return response()->json(compact('parkingNumber', 'parkingWithplaces', 'totalPlaces', 'placeswithReservations', 'mostReservedPlace'));
    }
}