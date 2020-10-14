<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public $successStatus = 200;
    public function register()
    {
        request()->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required|string'
        ]);

        $users = new User([
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'email' => request('email'),
            'phone' => request('phone'),
            'password' => Hash::make(request('password')),

        ]);

        if ($users->save())
            return response()->json(['data' => 'success'], $this->successStatus);
        else
            return response()->json(['error' => 'Unauthorised'], 401);
    }
    public function login(Request $request)
    {

        $credentials  = ['email' => request('email'), 'password' => request('password')];


        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role == 3) {
                $user['token'] = $user->createToken('Xpress')->accessToken;
                return response()->json(['data' => 'sucess'], $this->successStatus);
            } else
                return response()->json(['error' => 'Unauthorised'], 401);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }

        // $user = $request->user();
        // $tokenResult = $user->createToken('Personal Access Token');
        // $token = $tokenResult->token;
        // if ($request->remember_me)
        //     $token->expires_at = Carbon::now()->addWeeks(1);
        // $token->save();
        // if (Gate::allows('isAdmin'))
        // {
        //     return response()->json([
        //         'message'=>'Libarian login successfully',
        //         'user'=> Auth::user(),
        //         'access_token' => $tokenResult->accessToken,
        //         'token_type' => 'Bearer',
        //         'expires_at' => Carbon::parse(
        //         $tokenResult->token->expires_at
        //         )->toDateTimeString()
        //     ]);
        // }
        // elseif (Gate::allows('isUser'))
        // {
        //     return response()->json([
        //         'message'=>'Student login successfully',
        //         'user'=> Auth::user(),
        //         'access_token' => $tokenResult->accessToken,
        //         'token_type' => 'Bearer',
        //         'expires_at' => Carbon::parse(
        //         $tokenResult->token->expires_at
        //         )->toDateTimeString()
        //     ]);
        // }


    }
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json("User Logout Successfully");
    }
    public function user(Request $request)
    {
        return response()->json(
            [
                'data' => $request->user(),
                'token' => $request->user()->token()
            ]
        );
    }
}
