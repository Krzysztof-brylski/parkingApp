<?php

namespace App\Http\Controllers;

use App\DTO\ReservationDTO;
use App\Http\Requests\ReservationCreateRequest;
use App\Models\Reservation;
use App\Services\ReservationService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $cars=Auth::user()->Reservations()->with(['Car','Parking'])->get();
        return Response()->json($cars,200);
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param ReservationCreateRequest $request
     * @return Response
     */
    public function store(ReservationCreateRequest $request)
    {
        $fields=$request->validated();
        $reservation=(new ReservationService())->CreateReservation($fields);
        return Response()->json(array("paymentUrl"=>url("http://127.0.0.1:8888/payment/{$reservation->Payment->token}")),201);
    }

    /**
     * Display the specified resource.
     *
     * @param Reservation $reservation
     * @return Response
     */
    public function show(Reservation $reservation)
    {

        return Response()->json(
            (new ReservationDTO($reservation))->toArray(),
            200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Reservation $reservation
     * @return Response
     */
    public function destroy(Reservation $reservation)
    {
        (new ReservationService())->DeleteReservation($reservation);
        return Response()->json("deleted",200);
    }
}
