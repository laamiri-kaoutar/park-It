<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Reservation;
use App\Http\Requests\StoreReservationRequest;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return[ "reservations" =>Reservation::All() ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request ,Place $place)
    {
        // dd($place->id);
        // dd($request->All());


        $validated = $request->validated();
        // dd($validated);

        
       




        // $place = Place::findOrFail($request->place_id);

        // $existReservations= Reservation::where('place_id',$request->place_id)
        //                               ->whereBetween('from', [$request->from, $request->until])
        //                               ->orWhereBetween('until', [$request->from, $request->until])
        //                               ->orWhere(function ($query) use ($request) {
        //                                 $query->where('from', '<=', $request->from)
        //                                       ->where('until', '>=', $request->untill);
        //                                 })
        //                               ->exists();

        $existReservations = Reservation::where('place_id', $place->id)
                                      ->where('start', '<', $request->end)
                                      ->where('end', '>', $request->start)
                                      ->exists();
        // dd($existReservations);
       
                                  
        // if the place is reserved 
        if ($existReservations) {

            return response()->json(['error' => 'This place is already reserved for the selected period.'], 400);
        }

        // dd($request->user()->id);
        $validated['user_id'] = auth()->id();
        // $validated['user_id'] = 1;

        $validated['place_id'] = $place->id;



        $reservation = Reservation::create($validated);
        return response()->json(['message' => 'Reservation created successfully!', 'reservation' => $reservation], 201);


    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        return response()->json(['reservation' => $reservation]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreReservationRequest $request, Reservation $reservation)
    {
        // dd($place->id);
        // dd($request->All());


        $validated = $request->validated();
        // dd($validated);

        
       




        // $place = Place::findOrFail($request->place_id);

        // $existReservations= Reservation::where('place_id',$request->place_id)
        //                               ->whereBetween('from', [$request->from, $request->until])
        //                               ->orWhereBetween('until', [$request->from, $request->until])
        //                               ->orWhere(function ($query) use ($request) {
        //                                 $query->where('from', '<=', $request->from)
        //                                       ->where('until', '>=', $request->untill);
        //                                 })
        //                               ->exists();

        $existReservations = Reservation::where('place_id', $reservation->place_id)
                                      ->where('id','!=', $reservation->id)
                                      ->where('start', '<', $request->end)
                                      ->where('end', '>', $request->start)
                                      ->exists();
        // dd($existReservations);
       
                                  
        // if the place is reserved 
        if ($existReservations) {

            return response()->json(['error' => 'This place is already reserved for the selected period.']);
        }

        // dd($request->user()->id);
        // $validated['user_id'] = auth()->id();
        // // $validated['user_id'] = 1;

        // $validated['place_id'] = $place->id;



        $reservation->update($validated);
        return response()->json(['message' => 'Reservation updated successfully!', 'reservation' => $reservation], 201);


    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return response()->json(['message' => 'Reservation deleted successfully!']);
        
    }
}
