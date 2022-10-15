@extends('layout.app')
@section('content')
    <main class="signup-form">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <h1 class="text-bold font-monospace text-uppercase text-center m-4">New Admission</h1>
                <div class="col-md-10 col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('register.custom') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group mb-3 col-md-6">
                                        <input type="text" placeholder="First Name" id="first_name" class="form-control"
                                               name="fname"
                                               required autofocus>
                                        @if ($errors->has('fname'))
                                            <span class="text-danger">{{ $errors->first('fname') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group mb-3  col-md-6">
                                        <input type="text" placeholder="Last Name" id="last_name" class="form-control"
                                               name="lname"
                                               required autofocus>
                                        @if ($errors->has('lname'))
                                            <span class="text-danger">{{ $errors->first('lname') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="NIC Number" id="nic" class="form-control" name="nic"
                                           required>
                                    @if ($errors->has('nic'))
                                        <span class="text-danger">{{ $errors->first('nic') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <input type="date" id="birthday"
                                           class="form-control" name="birthday"
                                           required>
                                    @if ($errors->has('birthday'))
                                        <span class="text-danger">{{ $errors->first('birthday') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <select class="form-control" id="gender" name="gender">
                                        <option selected disabled value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="decline to answer">Decline to answer</option>
                                    </select>
                                    @if ($errors->has('gender'))
                                        <span class="text-danger">{{ $errors->first('gender') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Email" id="email_address" class="form-control"
                                           name="email" required autofocus>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Mobile Number" id="phone" class="form-control"
                                           name="phone" required autofocus>
                                    @if ($errors->has('phone'))
                                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <input type="password" placeholder="Password" id="password" class="form-control"
                                           name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <input type="password" placeholder="Confirm Password" id="password_confirmation"
                                           class="form-control"
                                           name="password_confirmation" required>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="remember"> Remember Me</label>
                                    </div>
                                </div>
                                <div class="d-grid mx-auto">
                                    <button type="submit" class="btn btn-primary btn-block">Sign up</button>
                                </div>
                                <div class="mt-3 text-center">
                                    <a href="{{ route('login') }}" class="text-decoration-none">Already have an account?
                                        Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
