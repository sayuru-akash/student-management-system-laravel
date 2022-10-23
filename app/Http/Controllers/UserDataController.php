<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDataController
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 'student') {
                return view('user.dashboard', compact('user'));
            } elseif ($user->role == 'admin') {
                return redirect('/admin');
            } else {
                return back()->withErrors('You are not allowed to access the requested resource!');
            }
        }

        return redirect("login")->withErrors('You are not allowed to access');
    }

    public function userDataModify(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->birthday = $request->birthday;
            $user->gender = $request->gender;
            $user->address = $request->address;
            $user->save();
            return redirect()->back()->with('message', 'User data updated successfully');
        }

        return redirect("login")->withErrors('You are not allowed to access');
    }
}
