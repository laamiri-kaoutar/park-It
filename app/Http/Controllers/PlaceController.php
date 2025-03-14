<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Http\Middleware\IsAdmin;
use Illuminate\Routing\Controller;
use App\Http\Requests\StorePlaceRequest;

/**
 * @OA\Tag(name="Places")
 */
class PlaceController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:sanctum');
        // $this->middleware(IsAdmin::class)->except(['index' ,'show' ,'search']);
    }

    /**
     * @OA\Get(
     *     path="/api/places",
     *     summary="Get all places",
     *     tags={"Places"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="parking_id", type="integer", example=1),
     *                 @OA\Property(property="number", type="string", example="A1"),
     *                 @OA\Property(property="hourly_price", type="number", format="float", nullable=true, example=5.50),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return Place::all();
    }

    /**
     * @OA\Post(
     *     path="/api/places",
     *     summary="Store a new place",
     *     tags={"Places"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="parking_id", type="integer", example=1),
     *             @OA\Property(property="number", type="string", example="A1"),
     *             @OA\Property(property="hourly_price", type="number", format="float", nullable=true, example=5.50)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Place created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="parking_id", type="integer", example=1),
     *             @OA\Property(property="number", type="string", example="A1"),
     *             @OA\Property(property="hourly_price", type="number", format="float", nullable=true, example=5.50),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     )
     * )
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
     * @OA\Get(
     *     path="/api/places/{id}",
     *     summary="Get a specific place",
     *     tags={"Places"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="parking_id", type="integer", example=1),
     *             @OA\Property(property="number", type="string", example="A1"),
     *             @OA\Property(property="hourly_price", type="number", format="float", nullable=true, example=5.50),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     )
     * )
     */
    public function show(Place $place)
    {
        return [ 
            'place'=> $place
        ];
    }

    /**
     * @OA\Get(
     *     path="/api/places/search/{searchKey}",
     *     summary="Search for places by number",
     *     tags={"Places"},
     *     @OA\Parameter(
     *         name="searchKey",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="parking_id", type="integer", example=1),
     *                 @OA\Property(property="number", type="string", example="A1"),
     *                 @OA\Property(property="hourly_price", type="number", format="float", nullable=true, example=5.50),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     )
     * )
     */
    public function search($searchKey)
    {
        $places = Place::where('number', 'LIKE', "%{$searchKey}%")->get();
        return [
            'places' => $places
        ];
    }

    /**
     * @OA\Put(
     *     path="/api/places/{id}",
     *     summary="Update a place",
     *     tags={"Places"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="parking_id", type="integer", example=1),
     *             @OA\Property(property="number", type="string", example="A1"),
     *             @OA\Property(property="hourly_price", type="number", format="float", nullable=true, example=5.50)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Place updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="parking_id", type="integer", example=1),
     *             @OA\Property(property="number", type="string", example="A1"),
     *             @OA\Property(property="hourly_price", type="number", format="float", nullable=true, example=5.50),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/places/{id}",
     *     summary="Delete a place",
     *     tags={"Places"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Place deleted successfully"
     *     )
     * )
     */
    public function destroy(Place $place)
    {
        $place->delete();
        return [ 
            'message'=> "The place deleted successfully"
        ];
    }
}