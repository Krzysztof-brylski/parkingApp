<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParkingCreateRequest;
use App\Http\Requests\ParkingUpdateRequest;
use App\Models\Parking;
use App\Services\ParkingService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ParkingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Response()->json(Parking::all()->toArray(),200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(ParkingCreateRequest $request)
    {
        $fields=$request->validated();
        (new ParkingService())->CreateParking($fields,Auth::user());
        return Response()->json("created",201);
    }

    /**
     * Display the specified resource.
     *
     * @param Parking $parking
     * @return Response
     */
    public function show(Parking $parking)
    {
        return Response()->json($parking->toArray(),200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ParkingUpdateRequest $request
     * @param Parking $parking
     * @return Response
     */
    public function update(ParkingUpdateRequest $request, Parking $parking)
    {
        $fields=$request->validated();
        (new ParkingService())->UpdateParking($fields);
        return Response()->json("updated",200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Parking $parking
     * @return Response
     */
    public function destroy(Parking $parking)
    {
        $parking->delete();
        return Response()->json("deleted",200);
    }
}
