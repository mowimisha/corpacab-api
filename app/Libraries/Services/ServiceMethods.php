<?php

namespace App\Libraries\Services;

use Image;
use App\Models\User;
use App\Service;
use App\Vehicle;
use Carbon\Carbon;
use App\Notifications\ServiceDue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;


class ServiceMethods
{
    public $request;
    protected $vehicle;

    public function __construct(Service $service)
    {
        return $this->service = $service;
    }

    public function getAllServices()
    {
        return Service::orderBy('created_at', 'desc')->paginate(25);
    }

    public function getAllDueSerives()
    {
        return Service::where('reminder_date', Carbon::today())->count();
    }

    public function getServiceById($id)
    {
        return Service::where('id', $id)->get();
    }

    public function storeService($request)
    {
        $service = new Service();
        $service->vehicle_registration = $request->vehicle_registration;
        $service->service_date = Carbon::parse($request->service_date);
        $service->current_odometer_reading = $request->current_odometer_reading;
        $service->kms_serviced = $request->kms_serviced;
        $service->next_kms_service = $request->next_kms_service;
        $service->battery_status = $request->battery_status;
        $service->reminder_date = Carbon::parse($request->reminder_date);
        $service->save();
    }

    public function updateService($request)
    {
        $service = Service::find($request->id);
        $service->vehicle_registration = $request->vehicle_registration;

        if (!empty($request->service_date)) {
            $service->service_date = Carbon::parse($request->service_date);
        }

        $service->current_odometer_reading = $request->current_odometer_reading;
        $service->kms_serviced = $request->kms_serviced;
        $service->next_kms_service = $request->next_kms_service;
        $service->battery_status = $request->battery_status;

        if (!empty($request->service_expiry)) {
            $service->service_expiry = Carbon::parse($request->service_expiry);
        }

        if (!empty($request->reminder_date)) {
            $service->reminder_date = Carbon::parse($request->reminder_date);
        }
        $service->save();
    }

    public function serviceReminder()
    {

        $users = User::get();
        $today = Carbon::today();
        $service_due_id = Service::where('reminder_date', $today)->value('id');

        DB::table('services')
            ->where('id', $service_due_id)
            ->update(['status' => 1]);

        //Notification::send($users, new ServiceDue());
    }

    public function serviceReminderVehicle()
    {
        $today = Carbon::today();
        $reg_no = Service::where('reminder_date', $today)->value('vehicle_registration');
        return $reg_no;
    }
}
