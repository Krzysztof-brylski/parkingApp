<?php

namespace App\Http\Controllers;

use App\Http\Requests\PricesCreateRequest;
use App\Http\Requests\PricesUpdateRequest;
use App\Models\Prices;
use App\Services\PricesService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PricesController extends Controller
{


    public function __construct()
    {
        // Middleware only applied to these methods
        $this->middleware('UserResourceOwnershipMiddelware')->only([
            'show',
            'destroy',
            'update'
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Response()->json(Prices::all()->toArray(),200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PricesCreateRequest $request
     * @return Response
     */
    public function store(PricesCreateRequest $request)
    {
        $fields=$request->validated();
        (new PricesService())->CreatePrices($fields);
        return Response()->json("created",201);
    }

    /**
     * Display the specified resource.
     *
     * @param Prices $prices
     * @return Response
     */
    public function show(Prices $prices)
    {
        return Response()->json($prices->toArray(),200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PricesUpdateRequest $request
     * @param Prices $prices
     * @return Response
     */
    public function update(PricesUpdateRequest $request, Prices $prices)
    {
        $fields=$request->validated();
        (new PricesService())->CreatePrices($fields,$prices);
        return Response()->json("updated",200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Prices $prices
     * @return Response
     */
    public function destroy(Prices $prices)
    {
        $prices->delete();
        return Response()->json("deleted",200);
    }
}
