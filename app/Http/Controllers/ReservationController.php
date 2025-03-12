<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;

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
    public function store(StoreReservationRequest $request ,$place_id)
    {
        $validated = $request->validate();

        $place = Place::findOrFail($request->place_id);

        $oldReservations= Reservation::where('place_id',$request->place_id)
                                      ->whereBetween('from', [$request->from, $request->until])
                                      ->orWhereBetween('until', [$request->from, $request->until]);



        // if the place is reserved 
        // return response()->json(['error' => 'This place is already reserved for the selected period.'], 400);

        $reservation = Reservation::create($validated);
        return response()->json(['message' => 'Reservation created successfully!', 'reservation' => $reservation], 201);




    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}
