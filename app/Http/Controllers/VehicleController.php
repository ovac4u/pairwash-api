<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vehicle\DeleteVehicle;
use App\Http\Requests\Vehicle\StoreVehicle;
use App\Http\Requests\Vehicle\UpdateVehicle;
use App\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vehicle = $request->user()->vehicles()->get();

        return responder()->success(['vehicles' => $vehicle]);
    }

    /**
     * Add a car to the database for the
     * authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVehicle $request)
    {
        $vehicle = $request->user()->vehicles()->create($request->validated());

        return responder()->success(['vehicle' => $vehicle]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        return responder()->success(['vehicle' => $vehicle]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVehicle $request, Vehicle $vehicle)
    {
        $vehicle->update($request->validated());

        return responder()->success(['vehicle' => $vehicle]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteVehicle $request, Vehicle $vehicle)
    {
        $vehicle->delete();

        return responder()->success(['vehicle' => $vehicle]);
    }
}
