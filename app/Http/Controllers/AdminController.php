<?php

namespace App\Http\Controllers;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;
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
                $users = User::orderBy('id', 'DESC')->where('role', 'student')->paginate(10);
                return view('admin.users', compact('users'));
            } else {
                return back()->withErrors('You are not allowed to access the requested resource!');
            }
            return redirect("login")->withErrors('You are not allowed to access the requested resource!');
        }
    }

    public function userDataModify(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $user = User::find($request->id);
            if (isset($request->fname)) {
                $user->fname = $request->fname;
            }
            if (isset($request->lname)) {
                $user->lname = $request->lname;
            }
            if (isset($request->nic)) {
                $user->nic = $request->nic;
            }
            if (isset($request->email)) {
                $user->email = $request->email;
            }
            if (isset($request->phone)) {
                $user->phone = $request->phone;
            }
            if (isset($request->birthday)) {
                $user->birthday = $request->birthday;
            }
            if (isset($request->gender)) {
                $user->gender = $request->gender;
            }
            if (isset($request->address)) {
                $user->address = $request->address;
            }
            $user->save();
            return redirect()->back()->with('message', 'User data updated successfully');
        }
        return redirect("login")->withErrors('You are not allowed to access the requested resource!');
    }

    public function userDelete(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $user = User::find($request->id);
            $user->delete();
            return redirect()->back()->with('err-message', 'User deleted successfully');
        }
        return redirect("login")->withErrors('You are not allowed to access the requested resource!');
    }

    public function userAdd(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $request->validate([
                'fname' => 'required',
                'lname' => 'required',
                'nic' => 'required|unique:users|min:10|max:12',
                'birthday' => 'required|date',
                'gender' => 'required',
                'email' => 'required|email:rfc,dns|unique:users',
                'phone' => 'required|digits:10|unique:users',
                'password' => 'required|min:8|regex:/[a-zA-Z]/|regex:/[0-9]/',
            ]);

            $student_id = IdGenerator::generate(['table' => 'users', 'field' => 'student_id', 'length' => 10, 'prefix' => 'ST-' . date('y'), 'reset_on_prefix_change' => true]);
            $data = $request->all();
            $check = $this->create($data, $student_id);
            event(new Registered($check));

            return redirect()->back()->with('message', 'User added successfully');
        }
        return redirect("login")->withErrors('You are not allowed to access the requested resource!');
    }

    public function create(array $data, string $student_id)
    {
        return User::create([
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'nic' => $data['nic'],
            'birthday' => $data['birthday'],
            'gender' => $data['gender'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'student_id' => $student_id,
        ]);
    }

    public function courses()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 'admin') {
                $courses = Course::orderBy('id', 'DESC')->paginate(10);
                return view('admin.courses', compact('courses'));
            } else {
                return back()->withErrors('You are not allowed to access the requested resource!');
            }
            return redirect("login")->withErrors('You are not allowed to access the requested resource!');
        }
    }

    public function courseDataModify(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $course = Course::find($request->id);
            if (isset($request->course_code)) {
                $course->course_code = $request->course_code;
            }
            if (isset($request->course_name)) {
                $course->course_name = $request->course_name;
            }
            if (isset($request->course_category)) {
                $course->course_category = $request->course_category;
            }
            if (isset($request->course_fee)) {
                $course->course_fee = $request->course_fee;
            }
            if (isset($request->course_start_date)) {
                $course->course_start_date = $request->course_start_date;
            }
            if (isset($request->course_duration)) {
                $course->course_duration = $request->course_duration;
            }
            if (isset($request->course_status)) {
                $course->course_status = $request->course_status;
            }
            $course->save();
            return redirect()->back()->with('message', 'Course data updated successfully');
        }
        return redirect("login")->withErrors('You are not allowed to access the requested resource!');
    }

    public function courseDelete(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $course = Course::find($request->id);
            $course->delete();
            return redirect()->back()->with('err-message', 'Course deleted successfully');
        }
        return redirect("login")->withErrors('You are not allowed to access the requested resource!');
    }

    public function courseAdd(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $request->validate([
                'course_code' => 'required|unique:courses',
                'course_name' => 'required',
                'course_category' => 'required',
                'course_fee' => 'required|numeric',
                'course_start_date' => 'required|date',
                'course_duration' => 'required',
            ]);

            $course = new Course();
            $course->course_code = $request->course_code;
            $course->course_name = $request->course_name;
            $course->course_category = $request->course_category;
            $course->course_fee = $request->course_fee;
            $course->course_start_date = $request->course_start_date;
            $course->course_duration = $request->course_duration;
            $course->save();

            return redirect()->back()->with('message', 'Course added successfully');
        }
        return redirect("login")->withErrors('You are not allowed to access the requested resource!');
    }

    public function coursesActive()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 'admin') {
                $courses = Course::where('course_status', true)->orderBy('id', 'DESC')->paginate(10);
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
                $enrolments = Enrollment::orderBy('id', 'DESC')->leftJoin('users', 'users.id', '=', 'enrollments.user_id')->leftJoin('courses', 'courses.id', '=', 'enrollments.course_id')->select('enrollments.*', 'users.student_id', 'courses.course_name')->paginate(15);
                return view('admin.enrolments', compact('enrolments'));
            } else {
                return back()->withErrors('You are not allowed to access the requested resource!');
            }
            return redirect("login")->withErrors('You are not allowed to access the requested resource!');
        }
    }

    public function enrolmentApprove(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $enrolment = Enrollment::find($request->id);
            $enrolment->enrollment_status = true;
            $enrolment->save();
            return redirect()->back()->with('message', 'You have successfully approved the enrolment');
        }
        return redirect("login")->withErrors('You are not allowed to access the requested resource!');
    }

    public function enrolmentDecline(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $enrolment = Enrollment::find($request->id);
            $enrolment->delete();
            return redirect()->back()->with('err-message', 'You have successfully declined the enrolment');
        }
        return redirect("login")->withErrors('You are not allowed to access the requested resource!');
    }

    public function enrolmentAdd(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $request->validate([
                'student_id' => 'required',
                'course_code' => 'required',
            ]);

            $user = User::where('student_id', $request->student_id)->first();
            $course = Course::where('course_code', $request->course_code)->first();

            if ($user && $course) {
                $enrollment = IdGenerator::generate(['table' => 'enrollments', 'length' => 15, 'field' => 'enrolment_id', 'prefix' => date('y') . '-' . $course->course_code . '-ST-1', 'reset_on_prefix_change' => false]);
                $invoice = IdGenerator::generate(['table' => 'enrollments', 'length' => 8, 'field' => 'invoice_id', 'prefix' => date('my'), 'reset_on_prefix_change' => true]);

                $enrolment = new Enrollment();
                $enrolment->user_id = $user->id;
                $enrolment->course_id = $course->id;
                $enrolment->enrolment_id = $enrollment;
                $enrolment->invoice_id = $invoice;
                $enrolment->enrollment_status = true;
                $enrolment->save();
                return redirect()->back()->with('message', 'Enrolment added successfully');
            } else {
                return redirect()->back()->withErrors('Invalid student id or course code');
            }

            return redirect()->back()->with('message', 'Enrolment added successfully');
        }
        return redirect("login")->withErrors('You are not allowed to access the requested resource!');
    }

    public function enrolmentsPending()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 'admin') {
                $enrolments = Enrollment::where('enrollment_status', false)->orderBy('id', 'DESC')->leftJoin('users', 'users.id', '=', 'enrollments.user_id')->leftJoin('courses', 'courses.id', '=', 'enrollments.course_id')->select('enrollments.*', 'users.student_id', 'courses.course_name')->paginate(15);
                return view('admin.enrolments', compact('enrolments'));
            } else {
                return back()->withErrors('You are not allowed to access the requested resource!');
            }
            return redirect("login")->withErrors('You are not allowed to access the requested resource!');
        }
    }

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
