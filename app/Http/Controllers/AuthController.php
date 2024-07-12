<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;
class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status_code' => 401,
                'message' => 'Unauthorized'
            ]);
        }
        $user = User::where('email',$request->email)->first();
        if (!Hash::check($request->password, $user->password, [])) {
            throw new Exception('Error in login');
        }
        try {
            $token = $user->createToken('api-token')->plainTextToken;
            return response()->json([
                'status_code' => 200,
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user'=>[
                    'user_id' => $user->user_id,
                    'avt_url' => $user->avt_url,
                    'username'=>$user->username,
                    'display_name'=> '@' . $user->display_name
                ]
            ]);
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function register(Request $request){
        Log::info('This is a test log message');

        $user  = User::create([
            'username' => $request->username ,
            'display_name' => $request->display_name,
            'real_name' => $request->real_name,
            'password'=> Hash::make($request->password),
            'email' => $request->email,
            'avt_url' => "https://www.facebook.com/groups/518282464857050/user/100078710535550/",
            'role_id' => 1,
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        $data = [
           'user' => $user,
           'token'=> $token
        ];
        // return response()->json(['message'=>'created successfully'],200);
        return response()->json($data,201);
    }
}
