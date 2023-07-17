<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function users()
    {
       
        $users = User::all();
        return response()->json(
            [
                'message' => 'success',
                'data' => $users,
                'status' => '200'
            ]
        );
      
    }

    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        // Authentication successful
        $user = Auth::user();
        $token = $user->createToken('token_name')->plainTextToken;
        return response()->json(['token' => $token, 'user' => $user], 200);
    } else {
        // Authentication failed
        return response()->json(['message' => 'Invalid credentials'], 401);
    }
}
}