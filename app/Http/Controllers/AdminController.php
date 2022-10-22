<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 'admin') {
                $users = User::all()->where('role', 'student')->count();
                $courses = Course::all()->where('course_status', true)->count();
                $enrolments = Enrollment::all()->where('enrollment_status', false)->count();
                return view('admin.dashboard', compact('user', 'users', 'courses', 'enrolments'));
            } else {
                return back()->withErrors('You are not allowed to access the requested resource!');
            }
            return redirect("login")->withErrors('You are not allowed to access the requested resource!');
        }
    }

    public function users()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 'admin') {
                $users = User::where('role', 'student')->paginate(15);
                return view('admin.users', compact('users'));
            } else {
                return back()->withErrors('You are not allowed to access the requested resource!');
            }
            return redirect("login")->withErrors('You are not allowed to access the requested resource!');
        }
    }

    public function courses()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 'admin') {
                $courses = Course::where('course_status', true)->paginate(15);
                return view('admin.courses', compact('courses'));
            } else {
                return back()->withErrors('You are not allowed to access the requested resource!');
            }
            return redirect("login")->withErrors('You are not allowed to access the requested resource!');
        }
    }

    public function enrolments()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 'admin') {
                $enrolments = Enrollment::where('enrollment_status', false)->leftJoin('users', 'users.id', '=', 'enrollments.user_id')->leftJoin('courses', 'courses.id', '=', 'enrollments.course_id')->select('enrollments.*', 'users.student_id', 'courses.course_name')->paginate(15);
                return view('admin.enrolments', compact('enrolments'));
            } else {
                return back()->withErrors('You are not allowed to access the requested resource!');
            }
            return redirect("login")->withErrors('You are not allowed to access the requested resource!');
        }
    }

//    public function approveEnrolment()
//    {
//        $enrolment_id = request('id');
//        $enrolment = Enrollment::find($enrolment_id);
//        $enrolment->enrollment_status = true;
//        $enrolment->save();
//        return redirect()->back()->with('message', 'You have successfully approved the enrolment');
//    }
//
//    public function rejectEnrolment()
//    {
//        $enrolment_id = request('id');
//        $enrolment = Enrollment::find($enrolment_id);
//        $enrolment->delete();
//        return redirect()->back()->with('message', 'You have successfully rejected the enrolment');
//    }

    public function certifications()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 'admin') {
                $certifications = Enrollment::all()->where('enrollment_status', true);
                return view('admin.certifications', compact('user', 'certifications'));
            } else {
                return back()->withErrors('You are not allowed to access the requested resource!');
            }
            return redirect("login")->withErrors('You are not allowed to access the requested resource!');
        }
    }
}
