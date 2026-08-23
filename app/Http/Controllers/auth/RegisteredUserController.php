<?php

namespace App\Http\Controllers\auth;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class RegisteredUserController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.register');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {   $user = User::create($request->validated());

        Auth::login($user);
        $user->sendEmailVerificationNotification();

        return redirect(route('verification.notice'))
            ->with('success', 'Sign up was successful, for verification please check your emails!');
    }
}
