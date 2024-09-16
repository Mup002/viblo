<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmail;
use App\Mail\TestMail;
use App\Services\UserService;
use Cookie;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\PersonalAccessToken;
use Mail;

class AuthController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
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
                'message' => 'Unauthorized...'
            ]);
        }

        $user = User::where('email', $request->email)->first();
        if (!Hash::check($request->password, $user->password, [])) {
            throw new Exception('Error in login');
        }
        try {
            $token = $user->createToken('api-token');
            $accessToken = $user->tokens()->where('name', 'api-token')->latest()->first();
            $accessToken->expires_at = now()->addMinutes(5);
            $accessToken->save();
            return response()->json([
                'user' => [
                    'user_id' => $user->user_id,
                    'role' => $user->roles()->first()->name,
                    'avt_url' => $user->avt_url,
                    'username' => $user->username,
                    'display_name' => '@' . $user->display_name,
                    'token' => $token->plainTextToken,
                ]
            ])->withCookie(
                    Cookie::make(env('AUTH_COOKIE_NAME'), $token->plainTextToken, 60, '/', '.viblo.local', false, true)
                );
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function register(Request $request)
    {
        $validateData = $request->validate([
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'display_name' => 'required',
       
        ]);
        try {

            if ($this->userService->checkMailUser($request->email)) {
                return response()->json(['message' => 'Email này đã được đăng ký','data'=>'0']);
            }
            if ($this->userService->checkMailVerify($request->email)) {
                return response()->json(['message' => 'Email đang đợi xác thực','data'=>'0']);
            }
            $user = $this->userService->pendingUser($request);
            SendEmail::dispatch($user);
            return response()->json(['message' => 'Hãy kiểm tra hòm thư của bạn!!','data'=>'1']);
        } catch (Exception $e) {
            logger()->error($e->getMessage());
            if (isset($user)) {
                $user->delete();
            }
            return response()->json(['error' => 'Failed to register user and send email.'], 500);
        }
    }
    public function logout(Request $request)
    {
        $cookieAT = Cookie::forget(env('AUTH_COOKIE_NAME'));
        if (!$cookieAT) {
            logger()->info("nullllllll");
        }
        logger()->info($cookieAT);
        auth()->user()->currentAccessToken()->delete();
        return response()->json(['success' => 'loggout'])->withCookie($cookieAT);
    }

    public function checkToken(Request $request)
    {
        $token = $request->bearerToken();
        if ($token) {
            $accessToken = PersonalAccessToken::findToken($token);
            if ($accessToken && $accessToken->expires_at && $accessToken->expires_at->isPast()) {
                $accessToken->delete();
                return response()->json(['status' => '401'], 401);
            } else if (!$accessToken) {
                return response()->json(['status' => '401'], 401);
            }
            return response()->json(['status' => '200'], 200);
        }
    }

    public function verify($token)
    {
        $rs = $this->userService->createUser($token);
        if($rs){
            $url = 'http://viblo.local/login'; 
            return redirect()->away($url);
        }
        return response()->json(['message'=>'falied']);

        
    }
    private function getCookie($token)
    {
        return cookie(
            env('AUTH_COOKIE_NAME'),
            $token,
            auth()->factory()->getTTL(),
            null,
            null,
            env('APP_DEBUG') ? false : true,
            true,
            false,
            'Strict'

        );
    }
}
