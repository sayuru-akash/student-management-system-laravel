<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->role == 'student') {
            return redirect('/dashboard');
        }
        if (Auth::check() && Auth::user()->role == 'admin') {
            return redirect('/admin');
        }
        return view('auth.login');
    }

    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            if (Auth::user()->role == 'admin') {
                return redirect()->intended('admin')
                    ->with('Signed in');
            } else {
                return redirect()->intended('dashboard')
                    ->with('Signed in');
            }
        }

        return redirect("login")->withErrors('Login details are not valid');
    }

    public function registration()
    {
        if (Auth::check() && Auth::user()->role == 'student') {
            return redirect('/dashboard');
        }
        if (Auth::check() && Auth::user()->role == 'admin') {
            return redirect('/admin');
        }
        return view('auth.register');
    }

    public function customRegistration(Request $request)
    {
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'nic' => 'required|unique:users|min:10|max:12',
            'birthday' => 'required|date',
            'gender' => 'required',
            'email' => 'required|email:rfc,dns|unique:users',
            'phone' => 'required|digits:10|unique:users',
            'password' => 'required|min:8|regex:/[0-9]/|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required',
            'agree' => 'required',
        ]);


        $student_id = IdGenerator::generate(['table' => 'users', 'field' => 'student_id', 'length' => 10, 'prefix' => 'ST-' . date('y'), 'reset_on_prefix_change' => true]);
        $data = $request->all();
        $check = $this->create($data, $student_id);
        event(new Registered($check));

        return redirect("dashboard")->with('You have signed-in');
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

    public function dashboard()
    {
        if (Auth::check()) {

            return view('dashboard');
        }

        return redirect("login")->with('You are not allowed to access');
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
}
