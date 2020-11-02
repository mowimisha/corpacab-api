<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function register_driver(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'national_id' => $request->national_id,
        ]);

        return response()->json($user, 201);
    }

    public function register_owner(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->name . '123'),
        ]);

        return response()->json($user, 201);
    }
}
