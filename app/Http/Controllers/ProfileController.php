<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit() {
        $user = Auth::user();
        return view('profile.edit', ['user' => $user]);
    }

    public function update(UpdateUserRequest $request) {
        $user = $request->user();

        $user->fill([
            'name' => $request['user.name'],
            'email' => $request['user.email']
        ]);

        if ($request->filled('user.password')) {
            $user->update([
                'password' => Hash::make($request['user.password']),
            ]);
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            $user->sendEmailVerificationNotification();
        }

        $user->save();

        return redirect(route('profile.edit'))->with('status', 'Your profile has been updated.');

    }
}
