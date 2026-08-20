<?php

namespace App\Http\Controllers\auth;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Str;
use App\Http\Controllers\Controller;

class ForgotPasswordController extends Controller
{
    
    public function index () {

        return view('auth.forgot-password');
    }

    public function send (Request $request) {

        $request->validate(['email' => 'required', 'string', 'email', 'max:255']);

        $status = Password::sendResetLink($request->only('email'));


        return $status === Password::ResetLinkSent
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['status' => __($status)]);
    }


    public function show(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }


    public function reset (Request $request) {
        $status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        return $status === Password::PasswordReset
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}

