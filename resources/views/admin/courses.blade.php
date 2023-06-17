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
            <h1 class="m-2 text-uppercase font-monospace fs-2">Manage Courses</h1>
            <a data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-sm btn-primary w-25">Add New Course</a>
            <a class="btn btn-sm btn-success w-25" href="{{ route('admin.coursesActive') }}">Filter Active Courses</a>
        </div>
        <form class="mt-2" action="{{ route('admin.courses') }}" method="GET">
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
                    <th scope="col">Code</th>
                    <th scope="col">Name</th>
                    <th scope="col">Year</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">Duration</th>
                    <th scope="col" class="d-sm-none d-md-none d-lg-block">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($courses as $course)
                    <tr class=@if($course->course_status) "table-success" @endif @if(!$course->course_status)
                        "table-danger"
                    @endif>
                    <th scope="row">{{ $loop->index }}</th>
                    <td>{{ $course->course_code }}</td>
                    <td>{{ $course->course_name }}</td>
                    <td>{{ $course->course_year }}</td>
                    <td>{{ $course->course_start_date }}</td>
                    <td>{{ $course->course_duration }}</td>
                    <td class="d-sm-none d-md-none d-lg-block">
                        <a data-bs-toggle="modal" data-bs-target="#viewModal{{ $course->id }}"
                           class="btn btn-sm btn-primary w-25">View</a>
                        <a data-bs-toggle="modal" data-bs-target="#editModal{{ $course->id }}"
                           class="btn btn-sm btn-warning w-25">Edit</a>
                        <a href="/admin/courses/delete?id={{ $course->id }}"
                           class="btn btn-sm btn-danger w-25">Delete</a>
                    </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $courses->links() }}
        </div>
    </div>
</div>

@foreach($courses as $course)
    <!-- View Data Modal -->
    <div class="modal fade" id="viewModal{{ $course->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Course Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Code</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="course_code" value="{{$course->course_code}}"
                                   disabled>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="course_name" value="{{$course->course_name}}"
                                   disabled>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Category</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="course_category"
                                   value="{{$course->course_category}}" disabled>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Fee</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="course_fee" value="{{$course->course_fee}}"
                                   disabled>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Start Date</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="course_start_date"
                                   value="{{$course->course_start_date}}" disabled>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Duration</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="course_duration"
                                   value="{{$course->course_duration}}" disabled>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Issued Year</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="course_year"
                                   value="{{$course->course_year}}" disabled>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Status</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="course_status"
                                   value="@if($course->course_status == 1) Active @endif @if($course->course_status == 0) Inactive @endif"
                                   disabled>
                        </div>
                    </div>
                    <br> <hr> <br>
                    <form action="#" method="POST" name="import-enr-form"
                    enctype="multipart/form-data">
                        @csrf		
                        <div class="text-center">
                            <a class="btn btn-primary btn-md" href="../admin/courses/student-list?id={{$course->course_code}}">Download Enrolled Students List</a>
                        </div> 
                    </form>
                    <form action="#" method="POST" name="import-cert-form"
                    enctype="multipart/form-data">
                        @csrf		
                        <div class="text-center">
                            <a class="btn btn-primary btn-md" href="../admin/courses/certificate-list?id={{$course->course_code}}">Download Issued Certificates List</a>
                        </div> 
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Data Modal -->
    <div class="modal fade" id="editModal{{ $course->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Course Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.courseModify') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" value="{{$course->id}}">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="col-form-label">Code</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" class="form-control" name="course_code"
                                       value="{{$course->course_code}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="col-form-label">Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" class="form-control" name="course_name"
                                       value="{{$course->course_name}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="col-form-label">Category</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" class="form-control" name="course_category"
                                       value="{{$course->course_category}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="col-form-label">Fee</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="number" class="form-control" name="course_fee"
                                       value="{{$course->course_fee}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="col-form-label">Start Date</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="date" class="form-control" name="course_start_date"
                                       value="{{$course->course_start_date}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="col-form-label">Duration</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <select class="form-control" id="course_duration" name="course_duration">
                                    <option disabled value="">Select Duration</option>
                                    <option value="6 Months" @if($course->course_duration == "6 Months") selected @endif>6 Months
                                    </option>
                                    <option value="1 Year" @if($course->course_duration == "1 Year") selected @endif>1 Year
                                    </option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="col-form-label">Issued Year</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" class="form-control" name="course_year" maxlength="4"
                                       value="{{$course->course_year}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="col-form-label">Status</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <select class="form-control" id="course_status" name="course_status">
                                    <option disabled value="">Select Status</option>
                                    <option value="1" @if($course->course_status == 1) selected @endif>Active</option>
                                    <option value="0" @if($course->course_status == 0) selected @endif>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<!-- Add Data Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Course Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.courseAdd') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Code</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="course_code" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="course_name" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Category</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="course_category" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Fee</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="number" class="form-control" name="course_fee" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Start Date</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="date" class="form-control" name="course_start_date" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Duration</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <select class="form-control" id="course_duration" name="course_duration">
                                <option disabled value="">Select Duration</option>
                                <option value="6 Months">6 Months</option>
                                <option value="1 Year">1 Year</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Issued Year</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="course_year" maxlength="4" required>
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
