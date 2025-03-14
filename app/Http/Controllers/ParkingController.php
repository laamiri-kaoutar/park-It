<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use App\Http\Requests\StoreParkingRequest;
use App\Http\Middleware\IsAdmin;
use Illuminate\Routing\Controller;

/**
 * @OA\Tag(
 *     name="Parkings",
 *     description="Endpoints related to parking management"
 * )
 */
class ParkingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware(IsAdmin::class)->only(['store', 'update', 'destroy']);
    }

    /**
     * @OA\Get(
     *     path="/api/parkings",
     *     summary="Get all parkings",
     *     tags={"Parkings"},
     *     @OA\Response(
     *         response=200,
     *         description="List of parkings",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Main Parking Lot"),
     *                 @OA\Property(property="total_places", type="integer", example=100),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return Parking::all();
    }

    /**
     * @OA\Post(
     *     path="/api/parkings",
     *     summary="Create a new parking",
     *     tags={"Parkings"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Main Parking Lot"),
     *             @OA\Property(property="total_places", type="integer", example=100)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Parking created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Main Parking Lot"),
     *             @OA\Property(property="total_places", type="integer", example=100),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function store(StoreParkingRequest $request)
    {
        $validated = $request->validated();
        $parking = Parking::create($validated);
        return ['parking' => $parking];
    }

    /**
     * @OA\Get(
     *     path="/api/parkings/{id}",
     *     summary="Get a parking by ID",
     *     tags={"Parkings"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the parking",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Parking details",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Main Parking Lot"),
     *             @OA\Property(property="total_places", type="integer", example=100),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Parking not found"
     *     )
     * )
     */
    public function show(Parking $parking)
    {
        return ['parking' => $parking];
    }

    /**
     * @OA\Put(
     *     path="/api/parkings/{id}",
     *     summary="Update a parking",
     *     tags={"Parkings"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the parking",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Main Parking Lot"),
     *             @OA\Property(property="total_places", type="integer", example=100)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Parking updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Main Parking Lot"),
     *             @OA\Property(property="total_places", type="integer", example=100),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Parking not found"
     *     )
     * )
     */
    public function update(StoreParkingRequest $request, Parking $parking)
    {
        $validated = $request->validated();
        $parking->update($validated);
        return ['parking' => $parking];
    }

    /**
     * @OA\Delete(
     *     path="/api/parkings/{id}",
     *     summary="Delete a parking",
     *     tags={"Parkings"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the parking",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Parking deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Parking not found"
     *     )
     * )
     */
    public function destroy(Parking $parking)
    {
        $parking->delete();
        return ['message' => "The parking was deleted successfully"];
    }
}