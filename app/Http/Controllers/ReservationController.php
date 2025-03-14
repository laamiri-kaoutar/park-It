<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Reservation;
use App\Http\Middleware\IsClient;
use App\Http\Requests\StoreReservationRequest;

/**
 * @OA\Tag(name="Reservations")
 */
class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware(IsClient::class)->only(['store', 'update', 'destroy']);
    }

    /**
     * @OA\Get(
     *     path="/api/reservations",
     *     summary="Get all reservations",
     *     tags={"Reservations"},
     *     @OA\Response(
     *         response=200,
     *         description="List of reservations",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="place_id", type="integer", example=1),
     *                 @OA\Property(property="start", type="string", format="date-time", example="2023-10-01T10:00:00Z"),
     *                 @OA\Property(property="end", type="string", format="date-time", example="2023-10-01T12:00:00Z"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(["reservations" => Reservation::all()], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/places/{place}/reservations",
     *     summary="Create a reservation",
     *     tags={"Reservations"},
     *     @OA\Parameter(
     *         name="place",
     *         in="path",
     *         required=true,
     *         description="Place ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="start", type="string", format="date-time", example="2023-10-01T10:00:00Z"),
     *             @OA\Property(property="end", type="string", format="date-time", example="2023-10-01T12:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Reservation created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="place_id", type="integer", example=1),
     *             @OA\Property(property="start", type="string", format="date-time", example="2023-10-01T10:00:00Z"),
     *             @OA\Property(property="end", type="string", format="date-time", example="2023-10-01T12:00:00Z"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Place is already reserved"
     *     )
     * )
     */
    public function store(StoreReservationRequest $request, Place $place)
    {
        $validated = $request->validated();
        
        $exists = Reservation::where('place_id', $place->id)
                             ->where('start', '<', $request->end)
                             ->where('end', '>', $request->start)
                             ->exists();

        if ($exists) {
            return response()->json(['error' => 'This place is already reserved for the selected period.'], 400);
        }

        $validated['user_id'] = auth()->id();
        $validated['place_id'] = $place->id;

        $reservation = Reservation::create($validated);

        return response()->json(['message' => 'Reservation created successfully!', 'reservation' => $reservation], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/reservations/{reservation}",
     *     summary="Get a reservation by ID",
     *     tags={"Reservations"},
     *     @OA\Parameter(
     *         name="reservation",
     *         in="path",
     *         required=true,
     *         description="Reservation ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reservation details",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="place_id", type="integer", example=1),
     *             @OA\Property(property="start", type="string", format="date-time", example="2023-10-01T10:00:00Z"),
     *             @OA\Property(property="end", type="string", format="date-time", example="2023-10-01T12:00:00Z"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     )
     * )
     */
    public function show(Reservation $reservation)
    {
        return response()->json(['reservation' => $reservation], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/reservations/{reservation}",
     *     summary="Update a reservation",
     *     tags={"Reservations"},
     *     @OA\Parameter(
     *         name="reservation",
     *         in="path",
     *         required=true,
     *         description="Reservation ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="start", type="string", format="date-time", example="2023-10-01T10:00:00Z"),
     *             @OA\Property(property="end", type="string", format="date-time", example="2023-10-01T12:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reservation updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="place_id", type="integer", example=1),
     *             @OA\Property(property="start", type="string", format="date-time", example="2023-10-01T10:00:00Z"),
     *             @OA\Property(property="end", type="string", format="date-time", example="2023-10-01T12:00:00Z"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Place is already reserved"
     *     )
     * )
     */
    public function update(StoreReservationRequest $request, Reservation $reservation)
    {
        if ($reservation->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validated();

        $exists = Reservation::where('place_id', $reservation->place_id)
                             ->where('id', '!=', $reservation->id)
                             ->where('start', '<', $request->end)
                             ->where('end', '>', $request->start)
                             ->exists();

        if ($exists) {
            return response()->json(['error' => 'This place is already reserved for the selected period.'], 400);
        }

        $reservation->update($validated);

        return response()->json(['message' => 'Reservation updated successfully!', 'reservation' => $reservation], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/reservations/{reservation}",
     *     summary="Delete a reservation",
     *     tags={"Reservations"},
     *     @OA\Parameter(
     *         name="reservation",
     *         in="path",
     *         required=true,
     *         description="Reservation ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reservation deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function destroy(Reservation $reservation)
    {
        if ($reservation->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $reservation->delete();
        return response()->json(['message' => 'Reservation deleted successfully!'], 200);
    }
}