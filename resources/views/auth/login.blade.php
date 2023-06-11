@extends('layout.app')
@section('content')
    <main class="login-form">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <h1 class="text-bold font-monospace text-uppercase text-center m-4">Student LogIn</h1>
                <div class="col-md-8 col-lg-6">
                    <div class="card">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <span>{{ $error }}</span></br>
                                @endforeach
                            </div>
                        @endif
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <div class="card-body">
                            <form method="POST" action="{{ route('login.custom') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Email" id="email" class="form-control" name="email"
                                           required
                                           autofocus>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
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
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>
                                <div class="d-grid mx-auto">
                                    <button type="submit" class="btn btn-primary btn-block mt-2">Sign In</button>
                                </div>
                                <div class="d-grid mx-auto">
                                    <a href="{{ route('register.custom') }}"
                                       class="btn btn-warning btn-block text-decoration-none mt-2">New
                                        Admission?</a>
                                </div>
                                <div class="mt-3 text-center">
                                    <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot
                                        Password? | Reset</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
