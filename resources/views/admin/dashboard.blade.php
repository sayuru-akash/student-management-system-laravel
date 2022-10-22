<html>
<head>
    <title>Administration - SITC Campus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-light navbar-expand-lg mb-5" style="background-color: #FFF5E4;">
    <div class="container">
        <a class="navbar-brand mr-auto" href="/admin"><img
                src="https://sitc.lk/wp-content/uploads/2021/11/photo_2021-11-23_18-40-47-300x92.png" alt="logo"
                width="120px"/></br><kbd class="font-monospace text-uppercase">Administration</kbd></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse w-100" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/admin/users">Students</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/courses">Courses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/enrolments">Enrolments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/certifications">Certifications</a>
                </li>
            </ul>
        </div>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="btn btn-block btn-danger" href="{{ route('signout') }}">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <div class="main-body">
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
        <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="https://i.ibb.co/y5Q9LVL/abstract-user-flat-4.png" alt="profile-pic"
                                 class="rounded-circle" width="150">
                            <div class="mt-3">
                                <h3 class="text-capitalize font-weight-bolder">
                                    {{ $user->fname.' '.$user->lname }}
                                </h3>
                                <p class="text-muted text-lowercase mb-2">{{ $user->email }}</p>
                                <p class="font-monospace text-uppercase">{{ 'ID: '.$user->student_id }}</p>
                                <a class="btn btn-danger" href="https://codezela.com/contact/">Contact Support</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header text-uppercase font-monospace">Administration</div>
                    <div class="card-body">
                        <div class="row mt-2 mb-2">
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Students</h5>
                                        <p class="card-text">You currently have {{$users}} students registered in
                                            the student portal.</p>
                                        <a href="/admin/users" class="btn btn-primary">Manage Students</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Courses</h5>
                                        <p class="card-text">You currently have {{$courses}} courses registered in the
                                            student portal</p>
                                        <a href="/admin/courses" class="btn btn-primary">Manage Courses</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2 mb-2">
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Enrolments</h5>
                                        <p class="card-text">You currently have {{$enrolments}} enrolments pending in
                                            the student portal.</p>
                                        <a href="/admin/enrolments" class="btn btn-primary">Manage Enrolments</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Certifications</h5>
                                        <p class="card-text">You currently have 0 certifications published in the
                                            student portal</p>
                                        <a href="/admin/certifications" class="btn btn-primary">Manage
                                            Certifications</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header text-uppercase font-monospace">Your Details</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">First Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $user->fname}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Last Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $user->lname}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{$user->email}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Phone</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{$user->phone}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Birthday</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{$user->birthday}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Gender</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{$user->gender}}
                            </div>
                        </div>
                        <hr>
                        <small class="text-muted">If you want to change your details, please contact an
                            authorized administrator.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes.minFooter')
</body>
</html>
