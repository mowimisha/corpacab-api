<?php

namespace App\Libraries\Users;

use Exception;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use App\Notifications\SingupNotification;

class UserMethods
{
    public $request;
    protected $user;

    public function __construct(User $user)
    {
        return $this->user = $user;
    }

    public function isAdmin($role)
    {
        return $role == 'admin';
    }

    public function isDriver($role)
    {
        return $role == 'driver';
    }

    public function isOwner($role)
    {
        return $role == 'owner';
    }

    public function getAllUsers()
    {
        return User::orderBy('created_at', 'desc')->paginate(15);
    }

    public function getAllStaff()
    {
        return DB::table('users')->where([
            ['role', '!=', 'driver'],
            ['role', '!=', 'owner'],
        ])->paginate(15);
    }

    public function getAllDrivers()
    {
        return User::where('role', 'driver')->orderBy('created_at', 'desc')->paginate(25);
    }

    public function getAllActiveDrivers()
    {
        return DB::table('users')->where([
            ['status', '=', '1'],
            ['role', '=', 'driver'],
        ])->count();
    }

    public function getAllOwners()
    {
        return User::where('role', 'owner')->orderBy('created_at', 'desc')->paginate(25);
    }

    public function storeUser($request)
    {
        $us = new User();
        $us->name = $request->name;
        $us->lastname = $request->lastname;
        $us->email = $request->email;
        $us->password = bcrypt($request->name . '@123');
        $us->role = $request->role;
        $us->save();
    }

    public function getUserById($id)
    {
        return User::where('id', $id)->get();
    }

    public function getVehicleByOwnerId($user_id)
    {
        $user_id = $this->user->id;
        return Vehicle::where('owner_id', $user_id)->get();
    }

    public function getVehicles()
    {
        return Vehicle::orderBy('created_at', 'desc')->get();
    }

    public function updateUser($request)
    {
        $us = User::find($request->id);
        $us->name = $request->name;
        $us->lastname = $request->lastname;
        $us->email = $request->email;
        $us->role = $request->role;

        $password = $request->password;
        $confirm_password = $request->confirm_password;

        if ($password != $confirm_password) {
            return back();
        } else {
            $us->password = bcrypt($request->password);
        }
        $us->save();
    }

    public function deleteUser($id)
    {
        $us = User::find($id);
        $us->delete();
    }

    public function storeDriver($request)
    {
        $us = new User();
        $us->name = $request->name;
        $us->middlename = $request->middlename;
        $us->lastname = $request->lastname;
        $us->email = $request->email;
        $us->role = 'driver';
        $us->national_id = $request->national_id;
        $us->password = bcrypt($request->name . '@123');
        $us->phone = $request->phone;
        $us->status = $request->status;

        if ($request->hasFile('driver_license')) {
            $driver_license = $request->file('driver_license');
            $filename5 = $request->name . "_" . $request->lastname . "_driverlicense_" . $driver_license->getClientOriginalName();
            $filename5 = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename5);
            Image::make($driver_license->getRealPath())->resize(600, 600)->save('uploads/users/documents/drivers_license/' . $filename5);
            $us->driver_license = $filename5;
        }

        if ($request->hasFile('good_conduct')) {
            $good_conduct = $request->file('good_conduct');
            $filename4 = $request->name . "_" . $request->lastname . "_good_conduct_" . $good_conduct->getClientOriginalName();
            $filename4 = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename4);
            Image::make($good_conduct->getRealPath())->resize(600, 600)->save('uploads/users/documents/good_conduct/' . $filename4);
            $us->good_conduct = $filename4;
        }

        if ($request->hasFile('profile_picture')) {
            $profile_picture = $request->file('profile_picture');
            $filename3 = $request->name . "_" . $request->lastname . "_profile_pic_" . $profile_picture->getClientOriginalName();
            $filename3 = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename3);
            Image::make($profile_picture->getRealPath())->resize(600, 600)->save('uploads/users/documents/profile_picture/' . $filename3);
            $us->profile_picture = $filename3;
        }

        if ($request->hasFile('psv')) {
            $psv = $request->file('psv');
            $filename2 = $request->name . "_" . $request->lastname . "_psv_" . $psv->getClientOriginalName();
            $filename2 = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename2);
            Image::make($psv->getRealPath())->resize(600, 600)->save('uploads/users/documents/psv/' . $filename2);
            $us->psv = $filename2;
        }

        $us->save();
    }

    public function storeDriverBrowser($request)
    {
        $us = new User();
        $us->name = $request->name;
        $us->middlename = $request->middlename;
        $us->lastname = $request->lastname;
        $us->email = $request->email;
        $us->password = bcrypt($request->password);
        $us->role = 'driver';
        $us->phone = $request->phone;

        if ($request->hasFile('driver_license')) {
            $driver_license = $request->file('driver_license');
            $filename5 = $request->name . "_" . $request->lastname . "_driverlicense_" . $driver_license->getClientOriginalName();
            $filename5 = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename5);
            Image::make($driver_license->getRealPath())->resize(600, 600)->save('uploads/users/documents/drivers_license/' . $filename5);
            $us->driver_license = $filename5;
        }

        if ($request->hasFile('good_conduct')) {
            $good_conduct = $request->file('good_conduct');
            $filename4 = $request->name . "_" . $request->lastname . "_good_conduct_" . $good_conduct->getClientOriginalName();
            $filename4 = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename4);
            Image::make($good_conduct->getRealPath())->resize(600, 600)->save('uploads/users/documents/good_conduct/' . $filename4);
            $us->good_conduct = $filename4;
        }

        if ($request->hasFile('profile_picture')) {
            $profile_picture = $request->file('profile_picture');
            $filename3 = $request->name . "_" . $request->lastname . "_profile_pic_" . $profile_picture->getClientOriginalName();
            $filename3 = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename3);
            Image::make($profile_picture->getRealPath())->resize(600, 600)->save('uploads/users/documents/profile_picture/' . $filename3);
            $us->profile_picture = $filename3;
        }

        if ($request->hasFile('psv')) {
            $psv = $request->file('psv');
            $filename2 = $request->name . "_" . $request->lastname . "_psv_" . $psv->getClientOriginalName();
            $filename2 = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename2);
            Image::make($psv->getRealPath())->resize(600, 600)->save('uploads/users/documents/psv/' . $filename2);
            $us->psv = $filename2;
        }

        $us->national_id = $request->national_id;
        //$us->notify(new SingupNotification());
        $us->save();
    }

    public function updateDriver($request)
    {
        $us = User::find($request->id);
        $us->name = $request->name;
        $us->middlename = $request->middlename;
        $us->lastname = $request->lastname;
        $us->email = $request->email;
        $us->password = bcrypt($request->password);
        $us->role = 'driver';
        $us->phone = $request->phone;
        $us->status = $request->status;

        if ($request->hasFile('driver_license')) {
            $driver_license = $request->file('driver_license');
            $filename5 = $request->name . "_" . $request->lastname . "_driverlicense_" . $driver_license->getClientOriginalName();
            $filename5 = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename5);
            Image::make($driver_license->getRealPath())->resize(600, 600)->save('uploads/users/documents/drivers_license/' . $filename5);
            $us->driver_license = $filename5;
        }

        if ($request->hasFile('good_conduct')) {
            $good_conduct = $request->file('good_conduct');
            $filename4 = $request->name . "_" . $request->lastname . "_good_conduct_" . $good_conduct->getClientOriginalName();
            $filename4 = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename4);
            Image::make($good_conduct->getRealPath())->resize(600, 600)->save('uploads/users/documents/good_conduct/' . $filename4);
            $us->good_conduct = $filename4;
        }

        if ($request->hasFile('profile_picture')) {
            $profile_picture = $request->file('profile_picture');
            $filename3 = $request->name . "_" . $request->lastname . "_profile_pic_" . $profile_picture->getClientOriginalName();
            $filename3 = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename3);
            Image::make($profile_picture->getRealPath())->resize(600, 600)->save('uploads/users/documents/profile_picture/' . $filename3);
            $us->profile_picture = $filename3;
        }

        if ($request->hasFile('psv')) {
            $psv = $request->file('psv');
            $filename2 = $request->name . "_" . $request->lastname . "_psv_" . $psv->getClientOriginalName();
            $filename2 = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename2);
            Image::make($psv->getRealPath())->resize(600, 600)->save('uploads/users/documents/psv/' . $filename2);
            $us->psv = $filename2;
        }

        $us->national_id = $request->national_id;
        $us->save();
    }

    public function deleteDriver($id)
    {
        $us = User::where('id', $id, 'role', 'driver')->get();
        $us->delete();
    }

    public function storeOwner($request)
    {
        $us = new User();
        $us->name = $request->name;
        $us->lastname = $request->lastname;
        $us->email = $request->email;
        $us->password = bcrypt($request->name . '@123');
        $us->role = 'owner';
        $us->phone = $request->phone;
        $us->save();
    }

    public function storePartnerBrowser($request)
    {
        $us = new User();
        $us->name = $request->name;
        $us->lastname = $request->lastname;
        $us->email = $request->email;
        $us->phone = $request->phone;
        $us->role = 'owner';
        $us->password = bcrypt($request->name . '@123');
        $us->save();
    }

    public function updateOwner($request)
    {
        $us = User::find($request->id);
        $us->name = $request->name;
        $us->middlename = $request->middlename;
        $us->lastname = $request->lastname;
        $us->email = $request->email;
        $us->phone = $request->phone;

        $password = $request->password;
        $confirm_password = $request->confirm_password;

        if ($password != $confirm_password) {
            return back();
        } else {
            $us->password = bcrypt($request->password);
        }
        $us->save();
    }

    public function deleteOwner($id)
    {
        $us = User::where('id', $id, 'role', 'owner')->get();
        $us->delete();
    }
}
