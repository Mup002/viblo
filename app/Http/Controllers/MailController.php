<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    //
    
    public function sendMail(Request $request)
    {
        $user = User::find($request->query('user_id'));
        Mail::to('clonemup01@gmail.com')->send(new TestMail($user));
        return response()->json(['message'=>'done']);
    }
}
