<?php

namespace App\Http\Controllers\api;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleResource;
use App\Http\Requests\Vehicle\CreateVehicleRequest;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return VehicleResource::collection(Vehicle::get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateVehicleRequest $request)
    {
        $user = Vehicle::create([
            'driver_id' => $request->driver_id,
            'owner_id' => $request->owner_id,
            'vehicle_image' => $request->vehicle_image,
            'registration_no' => $request->registration_no,
            'make' => $request->make,
            'model' => $request->model,
            'yom' => $request->yom,
            'color' => $request->color,
            'fuel_type' => $request->fuel_type,
            'status' => $request->status,
            'logbook' => $request->logbook,
            'insurance_sticker' => $request->insurance_sticker,
            'uber_inspection' => $request->uber_inspection,
            'ntsa_insepection' => $request->ntsa_insepection,
            'psv' => $request->psv,
        ]);
        return new VehicleResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        return new VehicleResource($vehicle);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $vehicle->update($request->all());
        return new VehicleResource($vehicle);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return response()->json(null, 204);
    }
}
