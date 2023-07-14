<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PasswordController extends Controller
{
    public function forgot(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->get()->toArray();

        if (!count($user)) {
            return response()->json([
                'status' => 'error',
                'message' => 'User with the email does not exist.'
            ]);
        }

        $token = Hash::make($user[0]['name'].$user[0]['email'].time());

        DB::table('password_reset_tokens')->insert([
            'email' => $user[0]['email'],
            'token' => $token
        ]);

        Mail::to($request->email)
            ->send(new ForgotPassword($token));

        $result = '';

        return response()->json($result);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8',
            'resetToken' => 'required'
        ]);

        $resetRecord = DB::table('password_reset_tokens')->where('token', $request->resetToken)->get()->toArray();

        if(!$resetRecord){
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid token!'
            ]);
        }

        User::where('email', $resetRecord[0]->email)
        ->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where('token', $request->resetToken)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Your password is successfully changed!'
        ]);
    }
}
