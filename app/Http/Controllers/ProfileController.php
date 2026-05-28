<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function index()
    {
        $user =
            Auth::guard('web')->user()
            ??
            Auth::guard('api')->user();

        return view('jobseeker.profile', compact('user'));
    }

    public function edit()
    {
        $user =
            Auth::guard('web')->user()
            ??
            Auth::guard('api')->user();

        return view('jobseeker.profile-edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user =
            Auth::guard('web')->user()
            ??
            Auth::guard('api')->user();

        // upload photo
        if($request->hasFile('photo')){

            $path = $request->file('photo')
                            ->store('profiles', 'public');

            $user->photo = $path;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->summary = $request->summary;
        $user->location = $request->location;

        $user->save();

        return redirect()
                ->route('profile')
                ->with('success', 'Profile updated!');
    }

    
}