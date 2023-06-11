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
                    <a class="nav-link" href="/admin/modules">Modules</a>
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
        @if(session()->has('err-message'))
            <div class="alert alert-danger">
                {{ session()->get('err-message') }}
            </div>
        @endif
        <div class="p-2 mb-4 text-center bg-light">
            <h1 class="m-2 text-uppercase font-monospace fs-2">Manage Enrolments</h1>
            <a data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-sm btn-primary w-25">Add New
                Enrolment</a>
            <a class="btn btn-sm btn-warning w-25" href="{{ route('admin.enrolmentsPending') }}">Filter Pending
                Enrolments</a>
        </div>
        <form class="mt-2" action="{{ route('admin.enrolments') }}" method="GET">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search..." name="search" id="search-input" @if(isset($_GET['search'])) value="{{ $_GET['search'] }}" @endif>
                <button class="btn btn-outline-primary" type="submit" id="search-btn">Search</button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-primary table-striped table-hover">
                <thead>
                <tr class="table-dark">
                    <th scope="col">#</th>
                    <th scope="col">Student ID</th>
                    <th scope="col">Course</th>
                    <th scope="col">Enrolment ID</th>
                    <th scope="col">Invoice ID</th>
                    <th scope="col" class="d-sm-none d-md-none d-lg-block">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($enrolments as $enrolment)
                    <tr class=@if($enrolment->enrollment_status) "table-success" @endif @if(!$enrolment->enrollment_status)
                        "table-warning"
                    @endif>
                    <th scope="row">{{ $loop->index }}</th>
                    <td>{{ $enrolment->student_id }}</td>
                    <td>{{ $enrolment->course_name }}</td>
                    <td>{{ $enrolment->enrolment_id }}</td>
                    <td># {{ $enrolment->invoice_id }}</td>
                    <td class="d-sm-none d-md-none d-lg-block">
                        @if(!$enrolment->enrollment_status)
                            <a href="/admin/enrolments/approve?id={{ $enrolment->id }}"
                               class="btn btn-sm btn-success">Approve</a>
                        @else
                            <button type="button" class="btn btn-sm btn-secondary" disabled>Approved</button>
                        @endif
                        <a href="/admin/enrolments/decline?id={{ $enrolment->id }}"
                           class="btn btn-sm btn-danger">Decline</a>
                    </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $enrolments->links() }}
        </div>
    </div>
</div>

<!-- Add Data Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Enrolment Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.enrolmentAdd') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Student ID</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="student_id" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Course Code</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <select class="form-select" name="course_code" required>
                                <option selected disabled value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->course_code }}">{{ $course->course_code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add New</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('includes.minFooter')
</body>
</html>
