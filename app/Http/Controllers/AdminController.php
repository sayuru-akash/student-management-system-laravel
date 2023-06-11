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
use App\Models\Module;
use App\Models\Certificate;
use App\Exports\UsersPerCourseExport;
use Maatwebsite\Excel\Facades\Excel;

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
                $modules = Module::all()->count();
                $certificates = Certificate::all()->count();
                return view('admin.dashboard', compact('user', 'users', 'courses', 'enrolments', 'modules', 'certificates'));
            } else {
                return back()->withErrors('You are not allowed to access the requested resource!');
            }
            return redirect("login")->withErrors('You are not allowed to access the requested resource!');
        }
    }

    public function users(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 'admin') {
                if ($request->search != null) {
                    $users = User::where('role', 'student')->where('fname', 'LIKE', '%' . $request->search . '%')->orWhere('lname', 'LIKE', '%' . $request->search . '%')->orWhere('email', 'LIKE', '%' . $request->search . '%')->orWhere('phone', 'LIKE', '%' . $request->search . '%')->orWhere('nic', 'LIKE', '%' . $request->search . '%')->paginate(10);
                } else{
                    $users = User::orderBy('id', 'DESC')->where('role', 'student')->paginate(10);
                }
                foreach ($users as $user) {
                    $enrolments = Enrollment::where('user_id', $user->id)->where('enrollment_status', '1')->get();
                    foreach ($enrolments as $enrolment) {
                        $enrolment->course_name = Course::where('id', $enrolment->course_id)->first()->course_name;
                        $enrolment->course_code = Course::where('id', $enrolment->course_id)->first()->course_code;
                        $enrolment->course_year = Course::where('id', $enrolment->course_id)->first()->course_year;
                    }
                    $user->enrolments = $enrolments;
                }
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
                'password' => 'required|min:8|regex:/[0-9]/',
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

    public function courses(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 'admin') {
                if ($request->search != null) {
                    $courses = Course::where('course_code', 'LIKE', '%' . $request->search . '%')->orWhere('course_name', 'LIKE', '%' . $request->search . '%')->orWhere('course_category', 'LIKE', '%' . $request->search . '%')->paginate(10);
                    return view('admin.courses', compact('courses'));
                }
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
            if (isset($request->course_year)) {
                $course->course_year = $request->course_year;
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
                'course_year' => 'required',
            ]);

            $course = new Course();
            $course->course_code = $request->course_code;
            $course->course_name = $request->course_name;
            $course->course_category = $request->course_category;
            $course->course_fee = $request->course_fee;
            $course->course_start_date = $request->course_start_date;
            $course->course_duration = $request->course_duration;
            $course->course_year = $request->course_year;
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

    public function downloadCourseStudentsList(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $course_code = $request->id;
            
            return (new UsersPerCourseExport($course_code))->download('Students List - ' . $course_code .'.xlsx');
        }
        return redirect("login")->withErrors('You are not allowed to access the requested resource!');
    }

    public function modules(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 'admin') {
                if ($request->search != null) {
                    $modules = Module::where('course_code', 'LIKE', '%' . $request->search . '%')->orWhere('module_name', 'LIKE', '%' . $request->search . '%')->paginate(10);
                    $course_codes = Course::select('course_code')->get();
                    return view('admin.modules', compact('user', 'modules', 'course_codes'));
                }
                $modules = Module::orderBy('id', 'DESC')->paginate(10);
                $course_codes = Course::select('course_code')->get();
                return view('admin.modules', compact('user', 'modules', 'course_codes'));
            } else {
                return back()->withErrors('You are not allowed to access the requested resource!');
            }
            return redirect("login")->withErrors('You are not allowed to access the requested resource!');
        }
    }

    public function moduleAdd(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $request->validate([
                'course_code' => 'required',
                'module_name' => 'required',
            ]);

            $module = new Module();
            $module->course_code = $request->course_code;
            $module->module_name = $request->module_name;
            $module->save();

            return redirect()->back()->with('message', 'Module added successfully');
        }
        return redirect("login")->withErrors('You are not allowed to access the requested resource!');
    }

    public function moduleDelete(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $module = Module::find($request->id);
            $module->delete();
            return redirect()->back()->with('err-message', 'Module deleted successfully');
        }
        return redirect("login")->withErrors('You are not allowed to access the requested resource!');
    }

    public function enrolments(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 'admin') {
                if ($request->search != null) {
                    $enrolments = Enrollment::orderBy('id', 'DESC')->leftJoin('users', 'users.id', '=', 'enrollments.user_id')->leftJoin('courses', 'courses.id', '=', 'enrollments.course_id')->select('enrollments.*', 'users.student_id', 'courses.course_name')->where('student_id', 'LIKE', '%' . $request->search . '%')->orWhere('course_name', 'LIKE', '%' . $request->search . '%')->orWhere('invoice_id', 'LIKE', '%' . $request->search . '%')->paginate(10);
                    $courses = Course::select('id', 'course_code')->where('course_status', true)->get();
                    return view('admin.enrolments', compact('enrolments', 'courses'));
                }
                $enrolments = Enrollment::orderBy('id', 'DESC')->leftJoin('users', 'users.id', '=', 'enrollments.user_id')->leftJoin('courses', 'courses.id', '=', 'enrollments.course_id')->select('enrollments.*', 'users.student_id', 'courses.course_name')->paginate(10);
                $courses = Course::select('id', 'course_code')->where('course_status', true)->get();
                return view('admin.enrolments', compact('enrolments', 'courses'));
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

            if (Enrollment::where('user_id', $user->id)->where('course_id', $course->id)->exists()) {
                return redirect()->back()->with('err-message', 'Enrolment already exists');
            }

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

    public function enrolmentsPending(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 'admin') {
                if ($request->search != null) {
                    $enrolments = Enrollment::where('enrollment_status', false)->orderBy('id', 'DESC')->leftJoin('users', 'users.id', '=', 'enrollments.user_id')->leftJoin('courses', 'courses.id', '=', 'enrollments.course_id')->select('enrollments.*', 'users.student_id', 'courses.course_name')->where('student_id', 'LIKE', '%' . $request->search . '%')->orWhere('course_name', 'LIKE', '%' . $request->search . '%')->orWhere('invoice_id', 'LIKE', '%' . $request->search . '%')->paginate(10);
                    $courses = Course::select('id', 'course_code')->where('course_status', true)->get();
                    return view('admin.enrolments', compact('enrolments', 'courses'));
                }
                $enrolments = Enrollment::where('enrollment_status', false)->orderBy('id', 'DESC')->leftJoin('users', 'users.id', '=', 'enrollments.user_id')->leftJoin('courses', 'courses.id', '=', 'enrollments.course_id')->select('enrollments.*', 'users.student_id', 'courses.course_name')->paginate(10);
                $courses = Course::select('id', 'course_code')->where('course_status', true)->get();
                return view('admin.enrolments', compact('enrolments', 'courses'));
            } else {
                return back()->withErrors('You are not allowed to access the requested resource!');
            }
            return redirect("login")->withErrors('You are not allowed to access the requested resource!');
        }
    }

    public function certifications(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 'admin') {
                if ($request->search != null) {
                    $certificates = Certificate::orderBy('id', 'DESC')->leftJoin('users', 'users.student_id', '=', 'certificates.student_id')->leftJoin('courses', 'courses.course_code', '=', 'certificates.course_code')->select('certificates.*', 'users.student_id', 'users.fname', 'users.lname', 'users.nic', 'users.phone', 'courses.course_name')->where('certificates.student_id', 'LIKE', '%' . $request->search . '%')->orWhere('certificates.course_code', 'LIKE', '%' . $request->search . '%')->orWhere('certificates.certificate_id', 'LIKE', '%' . $request->search . '%')->paginate(10);
                } else {
                    $certificates = Certificate::orderBy('id', 'DESC')->leftJoin('users', 'users.student_id', '=', 'certificates.student_id')->leftJoin('courses', 'courses.course_code', '=', 'certificates.course_code')->select('certificates.*', 'users.student_id', 'users.fname', 'users.lname', 'users.nic', 'users.phone', 'courses.course_name')->paginate(10);
                }
                $course_codes = Course::select('course_code')->get();
                $enrolments = Enrollment::all()->where('enrollment_status', true);
                return view('admin.certifications', compact('user', 'certificates', 'course_codes', 'enrolments'));
            } else {
                return back()->withErrors('You are not allowed to access the requested resource!');
            }
            return redirect("login")->withErrors('You are not allowed to access the requested resource!');
        }
    }

    public function certificateDataModify(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $request->validate([
                'certificate_id' => 'required',
                'course_result' => 'required',
            ]);
            $enrolment = Enrollment::where('enrolment_id', $request->certificate_id)->first();
            if ($enrolment) {
                $certificate = Certificate::where('certificate_id', $request->certificate_id)->first();
                if ($certificate) {
                    $certificate->course_result = $request->course_result;
                    $certificate->save();
                    return redirect()->back()->with('message', 'Certificate data modified successfully');
                } else {
                    return redirect()->back()->withErrors('Invalid certificate id');
                }
            } else {
                return redirect()->back()->withErrors('Invalid certificate id');
            }
            return redirect()->back()->with('message', 'Certificate data modified successfully');
        }
        return redirect("login")->withErrors('You are not allowed to access the requested resource!');
    }

    public function certificateAdd(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $request->validate([
                'certificate_id' => 'required',
                'course_result' => 'required',
            ]);

            $enrolment = Enrollment::where('enrolment_id', $request->certificate_id)->first();
            if ($enrolment) {
                $user = User::where('id', $enrolment->user_id)->first();
                $course = Course::where('id', $enrolment->course_id)->first();
                if ($user && $course) {
                    $certificate = new Certificate();
                    $certificate->certificate_id = $enrolment->enrolment_id;
                    $certificate->student_id = $user->student_id;
                    $certificate->course_code = $course->course_code;
                    $certificate->course_result = $request->course_result;
                    $certificate->save();
                    return redirect()->back()->with('message', 'Certificate added successfully');
                } else {
                    return redirect()->back()->withErrors('Invalid user id or course id detected');
                }
            } else {
                return redirect()->back()->withErrors('Invalid certificate id');
            }
            return redirect()->back()->with('message', 'Certificate added successfully');
        }
        return redirect("login")->withErrors('You are not allowed to access the requested resource!');
    }

    public function certificateDelete(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $certificate = Certificate::find($request->id);
            $certificate->delete();
            return redirect()->back()->with('err-message', 'Certificate deleted successfully');
        }
        return redirect("login")->withErrors('You are not allowed to access the requested resource!');
    }
}
