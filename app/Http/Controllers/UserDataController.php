<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Certificate;

class UserDataController
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 'student') {
                $certificates = Certificate::where('student_id', $user->student_id)->paginate(6);
                return view('user.dashboard', compact('user', 'certificates'));
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
