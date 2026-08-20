<?php

namespace App\Http\Controllers\auth;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class UserVerificationController extends Controller
{
    
   public function show () {
        if (Auth::user()->hasVerifiedEmail()) {
            return redirect('/')->with('success', 'Your accout is already verified!');
        }

        return view('auth.verify-email');
    }


    public function resend (Request $request) {
        $user = $request->user();
        $user->sendEmailVerificationNotification();

        return back()->with('success', 'Verification link sent!');
    }


    public function verify (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect(route('index'))->with('success', 'Your account is verified!');
    }
}

