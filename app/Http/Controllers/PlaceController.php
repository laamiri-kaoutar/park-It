<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Http\Middleware\IsAdmin;
use Illuminate\Routing\Controller;
use App\Http\Requests\StorePlaceRequest;


class PlaceController extends Controller
{
    public function __construct(){
        $this->middleware('auth:sanctum');
        $this->middleware(IsAdmin::class)->except(['index' ,'show']);

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Place::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlaceRequest $request)
    {
        
        $validated = $request->validated();
        $place = Place::create($validated);
        return [ 
            'place'=> $place
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Place $place)
    {
        return [ 
            'place'=> $place
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePlaceRequest $request, Place $place)
    {
        $validated = $request->validated();
        $place->update($validated);
        return [ 
            'place'=> $place
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Place $place)
    {
        $place->delete();
        return [ 
            'message'=> "The place deleted succesfuly"
        ];
    }
}
