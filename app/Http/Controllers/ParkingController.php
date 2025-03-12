<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use App\Http\Requests\StoreParkingRequest;
use App\Http\Middleware\IsAdmin; 
use Illuminate\Routing\Controller;


class ParkingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware(IsAdmin::class)->only(['store', 'update', 'destroy']);

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return Parking::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreParkingRequest $request)
    {
        $validated = $request->validated();
        $parking = Parking::create($validated);
        return [ 
            'parking'=> $parking
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Parking $parking)
    {
        return [ 
            'parking'=> $parking
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreParkingRequest $request, Parking $parking)
    {

        $validated = $request->validated();
        $parking->update($validated);
        return [ 
            'parking'=> $parking
        ];
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Parking $parking)
    {
        $parking->delete();
        return [ 
            'message'=> "The parking deleted succesfuly"
        ];
    }
}
