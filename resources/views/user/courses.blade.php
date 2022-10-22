<html>
<head>
    <title>Dashboard - SITC Campus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-light navbar-expand-lg mb-5" style="background-color: #FFF5E4;">
    <div class="container">
        <a class="navbar-brand mr-auto" href="/dashboard"><img
                src="https://sitc.lk/wp-content/uploads/2021/11/photo_2021-11-23_18-40-47-300x92.png" alt="logo"
                width="120px"/></br><kbd class="font-monospace text-uppercase">Student Portal</kbd></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse w-100" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/courses">Courses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://verify.sitc.lk">Results</a>
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
                                <a class="btn btn-primary" href="/courses">View Courses</a>
                                <a type="button" class="btn btn-outline-primary" href="https://verify.sitc.lk">
                                    Verify Results
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header text-uppercase font-monospace">Courses Available for Registration</div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($courses as $course)
                                <div class="col-sm-12 col-md-12 col-lg-6 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <span
                                                class="fw-bolder fs-5 text-primary text-capitalize">{{$course -> course_name}}</span>
                                            <div class="row pt-2">
                                                <div class="col-6">
                                                    <span class="fw-light">Department: </span>
                                                    <span class="fw-bolder">{{$course -> course_category}}</span>
                                                </div>
                                                <div class="col-6">
                                                    <span class="fw-light">Duration: </span>
                                                    <span class="fw-bolder">{{$course -> course_duration}}</span>
                                                </div>
                                            </div>
                                            <div class="row" pt-2>
                                                <div class="col-12 mt-2 mb-2">
                                                    <span class="fw-light">Fee: </span>
                                                    <span class="fw-bolder">{{$course -> course_fee}}</span>
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <span class="fw-light">Commencement Date: </span>
                                                    <span class="fw-bolder">{{$course -> course_start_date}}</span>
                                                </div>
                                            </div>
                                            <a href="{{'./enrol?id=' . $course->id}}" class="btn btn-primary">Enrol
                                                Now</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $courses->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes.minFooter')
</body>
</html>



