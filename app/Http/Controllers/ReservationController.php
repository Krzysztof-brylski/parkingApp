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
     * Store a newly created resource in storage.
     *
     * @param ReservationCreateRequest $request
     * @return Response
     */
    public function store(ReservationCreateRequest $request)
    {
        $fields=$request->validated();
        (new ReservationService())->CreateReservation($fields);
        return Response()->json("booked",201);
    }

    /**
     * Display the specified resource.
     *
     * @param Reservation $reservation
     * @return Response
     */
    public function show(Reservation $reservation)
    {

//        $startTime= Carbon::createFromFormat(
//            'Y-m-d H:i',
//            "2023-02-10 15:51"
//        );
//        dd($startTime->setTimezone("Europe/Warsaw")->toDateTimeString());
        //todo make middleware for resource read permission
        if(Auth::id() == $reservation->Car()->first()->users_id){
            return Response()->json(
                (new ReservationDTO($reservation))->toArray(),
                200);
        }
        return  Response()->json("access deny",403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Reservation $reservation
     * @return Response
     */
    public function destroy(Reservation $reservation)
    {
        if(Auth::id() == $reservation->Car()->first()->users_id){
            (new ReservationService())->DeleteReservation($reservation);
            return Response()->json("deleted",200);
        }
        return  Response()->json("access deny",403);
    }
}
