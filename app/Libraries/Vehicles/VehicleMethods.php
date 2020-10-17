<?php

namespace App\Libraries\Vehicles;

use App\Models\User;
use App\Vehicle;
use Intervention\Image\Facades\Image;

class VehicleMethods
{
    public $request;
    protected $vehicle;

    public function __construct(Vehicle $vehicle)
    {
        return $this->vehicle = $vehicle;
    }

    public function getAllVehicles()
    {
        return Vehicle::orderBy('created_at', 'desc')->paginate(25);
    }

    public function getAllActiveVehicles()
    {
        return Vehicle::where('status', '2')->orderBy('created_at', 'desc')->count();

        // return DB::table('vehicles')->where([
        //     ['status', '=', '1'],
        //     ['role', '=', 'driver'],
        // ])->count();
    }

    public function getAllDrivers()
    {
        return User::where('role', 'driver')->orderBy('created_at', 'desc')->get();
    }
    public function getAllOwners()
    {
        return User::where('role', 'owner')->orderBy('created_at', 'desc')->get();
    }

    public function getVehicleById($id)
    {
        return Vehicle::where('id', $id)->get();
    }

    public function storeVehicle($request)
    {
        $vehicle = new Vehicle();
        $vehicle->registration_no = str_replace(' ', '', strtoupper($request->registration_no));
        $vehicle->owner_id = $request->owner_id;
        $vehicle->driver_id = $request->driver_id;
        $vehicle->make = strtoupper($request->make);
        $vehicle->model = strtoupper($request->model);
        $vehicle->yom = $request->yom;
        $vehicle->color = $request->color;
        $vehicle->fuel_type = $request->fuel_type;
        $vehicle->status = $request->status;

        if ($request->hasFile('vehicle_image')) {
            $vehicle_image = $request->file('vehicle_image');
            $filename = str_replace(' ', '', strtoupper($request->registration_no)) . "_" . $vehicle_image->getClientOriginalName();
            $filename = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename);
            Image::make($vehicle_image->getRealPath())->resize(600, 600)->save('uploads/vehicles/documents/vehicle_images/' . $filename);
            $vehicle->vehicle_image = $filename;
        }

        if ($request->hasFile('logbook')) {
            $logbook = $request->file('logbook');
            $filename2 = str_replace(' ', '', strtoupper($request->registration_no)) . "_logbook_" . $logbook->getClientOriginalName();
            $filename2 = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename2);
            Image::make($logbook->getRealPath())->resize(600, 600)->save('uploads/vehicles/documents/logbooks/' . $filename2);
            $vehicle->logbook = $filename2;
        }

        if ($request->hasFile('insurance_sticker')) {
            $insurance_sticker = $request->file('insurance_sticker');
            $filename3 = str_replace(' ', '', strtoupper($request->registration_no)) . "_insurance_" . $insurance_sticker->getClientOriginalName();
            $filename3 = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename3);
            Image::make($insurance_sticker->getRealPath())->resize(600, 600)->save('uploads/vehicles/documents/insurance_stickers/' . $filename3);
            $vehicle->insurance_sticker = $filename3;
        }

        if ($request->hasFile('uber_inspection')) {
            $uber_inspection = $request->file('uber_inspection');
            $filename4 = str_replace(' ', '', strtoupper($request->registration_no)) . "_uber_inspection_" . $uber_inspection->getClientOriginalName();
            $filename4 = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename4);
            Image::make($uber_inspection->getRealPath())->resize(600, 600)->save('uploads/vehicles/documents/uber_inspection/' . $filename4);
            $vehicle->uber_inspection = $filename4;
        }

        if ($request->hasFile('psv')) {
            $psv = $request->file('psv');
            $filename5 = str_replace(' ', '', strtoupper($request->registration_no)) . "_psv_" . $psv->getClientOriginalName();
            $filename5 = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename5);
            Image::make($psv->getRealPath())->resize(600, 600)->save('uploads/vehicles/documents/psv/' . $filename5);
            $vehicle->psv = $filename5;
        }

        if ($request->hasFile('ntsa_inspection')) {
            $ntsa_inspection = $request->file('ntsa_inspection');
            $filename6 = str_replace(' ', '', strtoupper($request->registration_no)) . "_ntsa_inspection_" . $ntsa_inspection->getClientOriginalName();
            $filename6 = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename6);
            Image::make($ntsa_inspection->getRealPath())->resize(600, 600)->save('uploads/vehicles/documents/ntsa_inspection/' . $filename6);
            $vehicle->ntsa_inspection = $filename6;
        }

        $vehicle->save();
    }

    public function updateVehicle($request)
    {
        $vehicle = Vehicle::find($request->id);

        $vehicle->registration_no = str_replace(' ', '', strtoupper($request->registration_no));
        $vehicle->owner_id = $request->owner_id;
        $vehicle->driver_id = $request->driver_id;
        $vehicle->make = strtoupper($request->make);
        $vehicle->model = strtoupper($request->model);
        $vehicle->yom = $request->yom;
        $vehicle->color = $request->color;
        $vehicle->fuel_type = $request->fuel_type;
        $vehicle->status = $request->status;

        if ($request->hasFile('vehicle_image')) {
            $vehicle_image = $request->file('vehicle_image');
            $filename = str_replace(' ', '', strtoupper($request->registration_no)) . "_" . $vehicle_image->getClientOriginalName();
            $filename = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename);
            Image::make($vehicle_image->getRealPath())->resize(600, 600)->save('uploads/vehicles/documents/vehicle_images/' . $filename);
            $vehicle->vehicle_image = $filename;
        }

        if ($request->hasFile('logbook')) {
            $logbook = $request->file('logbook');
            $filename2 = str_replace(' ', '', strtoupper($request->registration_no)) . "_logbook_" . $logbook->getClientOriginalName();
            $filename2 = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename2);
            Image::make($logbook->getRealPath())->resize(600, 600)->save('uploads/vehicles/documents/logbooks/' . $filename2);
            $vehicle->logbook = $filename2;
        }

        if ($request->hasFile('insurance_sticker')) {
            $insurance_sticker = $request->file('insurance_sticker');
            $filename3 = str_replace(' ', '', strtoupper($request->registration_no)) . "_insurance_" . $insurance_sticker->getClientOriginalName();;
            $filename3 = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename3);
            Image::make($insurance_sticker->getRealPath())->resize(600, 600)->save('uploads/vehicles/documents/insurance_stickers/' . $filename3);
            $vehicle->insurance_sticker = $filename3;
        }

        if ($request->hasFile('uber_inspection')) {
            $uber_inspection = $request->file('uber_inspection');
            $filename4 = str_replace(' ', '', strtoupper($request->registration_no)) . "_uber_inspection_" . $uber_inspection->getClientOriginalName();
            $filename4 = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename4);
            Image::make($uber_inspection->getRealPath())->resize(600, 600)->save('uploads/vehicles/documents/uber_inspection/' . $filename4);
            $vehicle->uber_inspection = $filename4;
        }

        if ($request->hasFile('psv')) {
            $psv = $request->file('psv');
            $filename5 = str_replace(' ', '', strtoupper($request->registration_no)) . "_psv_" . $psv->getClientOriginalName();
            $filename5 = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename5);
            Image::make($psv->getRealPath())->resize(600, 600)->save('uploads/vehicles/documents/psv/' . $filename5);
            $vehicle->psv = $filename5;
        }

        if ($request->hasFile('ntsa_inspection')) {
            $ntsa_inspection = $request->file('ntsa_inspection');
            $filename6 = str_replace(' ', '', strtoupper($request->registration_no)) . "_ntsa_inspection_" . $ntsa_inspection->getClientOriginalName();
            $filename6 = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename6);
            Image::make($ntsa_inspection->getRealPath())->resize(600, 600)->save('uploads/vehicles/documents/ntsa_inspection/' . $filename6);
            $vehicle->ntsa_inspection = $filename6;
        }

        $vehicle->save();
    }
}
