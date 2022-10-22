<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class CourseController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 'student') {
                $courses = Course::where('course_status', true)->paginate(6);
                return view('user.courses', compact('user', 'courses'));
            } else {
                return back()->withErrors('You are not allowed to access the requested resource!');
            }
        }

        return redirect("login")->withErrors('You are not allowed to access');
    }

    public function enrollUser()
    {
        $course_id = request('id');
        $course = Course::find($course_id);
        $course_code = $course->course_code;
        $enrollment = IdGenerator::generate(['table' => 'enrollments', 'length' => 15, 'field' => 'enrolment_id', 'prefix' => date('y') . '-' . $course_code . '-ST-1', 'reset_on_prefix_change' => false]);
        $invoice = IdGenerator::generate(['table' => 'enrollments', 'length' => 8, 'field' => 'invoice_id', 'prefix' => date('my'), 'reset_on_prefix_change' => true]);
        if (Auth::check()) {
            $user = Auth::user();
            try {
                Enrollment::create([
                    'user_id' => $user->id,
                    'course_id' => $course_id,
                    'enrolment_id' => $enrollment,
                    'invoice_id' => $invoice,
                ]);
            } catch (\Exception $e) {
                return redirect()->back()->withErrors('You have already requested enrolment to this course');
            }
            return redirect()->back()->with('message', 'You have successfully enrolled in the course');
        }

        return redirect("login")->withErrors('You are not allowed to access');
    }
}
