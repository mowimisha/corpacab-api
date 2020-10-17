<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Notifications\ServiceDue;
use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\Service\CreateServiceRequest;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ServiceResource::collection(Service::paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateServiceRequest $request)
    {
        $service = Service::create([
            'vehicle_registration' => $request->vehicle_registration,
            'service_date' => $request->service_date,
            'current_odometer_reading' => $request->current_odometer_reading,
            'kms_serviced' => $request->kms_serviced,
            'next_kms_service' => $request->next_kms_service,
            'reminder_date' => $request->reminder_date,
            'status' => $request->status,
            'battery_status' => $request->battery_status,
        ]);
        return new ServiceResource($service);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return new ServiceResource($service);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $service->update($request->all());
        return new ServiceResource($service);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return response()->json(null, 204);
    }

    // public function sendNotification()
    // {

    //     $this->services->serviceReminder();
    //     $email = User::get();
    //     $vehicle = $this->services->serviceReminderVehicle();
    //     $details = [
    //         'greeting' => 'Hi Admin',
    //         'body' => 'This is Service Almost Due Notication for vehicle' . " " . $vehicle,
    //         'actionText' => 'Login the site for more details',
    //         'actionURL' => url('https://corpcab.co.ke/login'),
    //     ];

    //     Notification::send($email, new ServiceDue($details));
    //     return redirect('all-users');
    // }
}
