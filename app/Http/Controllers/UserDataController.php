<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Certificate;
use App\Models\Enrollment;
use App\Models\Course;

class UserDataController
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 'student') {
                $certificates = Certificate::where('student_id', $user->student_id)->get();
                $enrolments = Enrollment::where('user_id', $user->id)->get();
                foreach ($certificates as $certificate) {
                    $certificate->course_name = Course::where('course_code', $certificate->course_code)->first()->course_name;
                    $certificate->course_code = Course::where('course_code', $certificate->course_code)->first()->course_code;
                    $certificate->course_year = Course::where('course_code', $certificate->course_code)->first()->course_year;
                }
                foreach ($enrolments as $enrolment) {
                    $enrolment->course_name = Course::where('id', $enrolment->course_id)->first()->course_name;
                    $enrolment->course_code = Course::where('id', $enrolment->course_id)->first()->course_code;
                    $enrolment->course_year = Course::where('id', $enrolment->course_id)->first()->course_year;
                }
                return view('user.dashboard', compact('user', 'certificates', 'enrolments'));
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
