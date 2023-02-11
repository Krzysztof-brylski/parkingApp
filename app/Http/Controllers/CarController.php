<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarCreateRequest;
use App\Http\Requests\CarUpdateRequest;
use App\Models\Car;
use App\Services\CarService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $cars=Auth::user()->Cars->all();
        return Response()->json($cars,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CarCreateRequest $request
     * @return Response
     */
    public function store(CarCreateRequest $request)
    {
        $fields=$request->validated();
        (new CarService())->CreateCar($fields, Auth::user());
        return Response()->json("created",201);
    }

    /**
     * Display the specified resource.
     *
     * @param Car $car
     * @return Response
     */
    public function show(Car $car)
    {
        return Response()->json($car->toArray(),200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CarUpdateRequest $request
     * @param Car $car
     * @return Response
     */
    public function update(CarUpdateRequest $request, Car $car)
    {
        if($car->users_id != Auth::id()){
            abort(403);
        }
        $fields=$request->validated();
        (new CarService())->UpdateCar($fields, $car);
        return Response()->json("updated",200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Car $car
     * @return Response
     */
    public function destroy(Car $car)
    {
        $car->delete();
        return Response()->json("deleted",200);
        //
    }
}
