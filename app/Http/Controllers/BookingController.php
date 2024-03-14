<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'string|required',
            'email' => 'email|required',
            'contact' => 'string|required',
            'local_guests' => 'numeric|min:0',
            'foreign_guests' => 'numeric|min:0',
            'event_date' => 'date|required',
            'pick_up' => 'string|nullable',
            'special_requests' => 'string|nullable',
            'client' => 'string|required',
            'product' => 'required|exists:products,id',
        ]);

        $clientId = User::unfork($request->client ?? null);
        if(!$clientId && !($clientData = User::find($clientId))) {
            return response()->json('ID not found.', 422);
        }

        if($booking = Booking::create([
            'client_id' => $clientId,
            'product_id' => $request->product,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'contact' => $request->contact,
            'local_guests' => $request->local_guests,
            'foreign_guests' => $request->foreign_guests,
            'event_date' => $request->event_date,
            'pick_up_info' => $request->pick_up,
            'special_requests' => $request->special_requests,
        ])) {
            return response()->json('Successfully booked.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        //
    }

    public function generateBookToken() {

    }
}