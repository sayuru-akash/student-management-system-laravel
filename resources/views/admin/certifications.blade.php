<html>
<head>
    <title>Administration - SITC Campus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"/>
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
        @if(session()->has('err-message'))
            <div class="alert alert-danger">
                {{ session()->get('err-message') }}
            </div>
        @endif
        <div class="p-2 mb-4 text-center bg-light">
            <h1 class="m-2 text-uppercase font-monospace fs-2">Manage Certifications</h1>
            <a data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-sm btn-primary w-25">Add New
                Certificate</a>
        </div>
        <div class="table-responsive">
            <table class="table table-primary table-striped table-hover">
                <thead>
                <tr class="table-dark">
                    <th scope="col">#</th>
                    <th scope="col">Cert. ID</th>
                    <th scope="col">St. ID</th>
                    <th scope="col">Course</th>
                    <th scope="col">Result</th>
                    <th scope="col" class="d-sm-none d-md-none d-lg-block">Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach($certificates as $certificate)
                    <tr>
                        <th scope="row">{{ $loop->index }}</th>
                        <td>{{ $certificate->certificate_id }}</td>
                        <td>{{ $certificate->student_id }}</td>
                        <td>{{ $certificate->course_code }}</td>
                        <td>{{ $certificate->course_result }}</td>
                        <td class="d-sm-none d-md-none d-lg-block">
                            <a data-bs-toggle="modal" data-bs-target="#viewModal{{ $certificate->id }}"
                               class="btn btn-sm btn-primary w-25">View</a>
                            <a data-bs-toggle="modal" data-bs-target="#editModal{{ $certificate->id }}"
                               class="btn btn-sm btn-warning w-25">Edit</a>
                            <a href="/admin/certifications/delete?id={{ $certificate->id }}"
                               class="btn btn-sm btn-danger w-25">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            {!! $certificates->links() !!}
        </div>
    </div>
</div>


@foreach($certificates as $certificate)
    <!-- View Data Modal -->
    <div class="modal fade" id="viewModal{{ $certificate->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Certificate Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Student Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="student_name"
                                   value="{{$certificate->fname . ' ' . $certificate->lname}}" disabled>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Student ID</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="lname" value="{{$certificate->student_id}}"
                                   disabled>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">NIC</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="nic" value="{{$certificate->nic}}" disabled>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Phone</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="phone" value="{{$certificate->phone}}"
                                   disabled>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Certificate ID</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="certificate_id"
                                   value="{{$certificate->certificate_id}}"
                                   disabled>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Course Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="gender" value="{{$certificate->course_name}}"
                                   disabled>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Result</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="address"
                                   value="{{$certificate->course_result}}" disabled>
                        </div>
                    </div>
                    <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Data Modal -->
    <div class="modal fade" id="editModal{{ $certificate->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Certificate Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.certificateModify') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" value="{{$certificate->id}}">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="col-form-label">Certificate ID</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" class="form-control" name="certificate_id"
                                       value="{{$certificate->certificate_id}}" readonly>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="col-form-label">Course Result</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <select class="form-control" name="course_result">
                                    <option value="A+" @if($certificate->course_result == 'A+') selected @endif>A+
                                    </option>
                                    <option value="A" @if($certificate->course_result == 'A') selected @endif>A</option>
                                    <option value="A-" @if($certificate->course_result == 'A-') selected @endif>A-
                                    </option>
                                    <option value="B+" @if($certificate->course_result == 'B+') selected @endif>B+
                                    </option>
                                    <option value="B" @if($certificate->course_result == 'B') selected @endif>B</option>
                                    <option value="B-" @if($certificate->course_result == 'B-') selected @endif>B-
                                    </option>
                                    <option value="C+" @if($certificate->course_result == 'C+') selected @endif>C+
                                    </option>
                                    <option value="C" @if($certificate->course_result == 'C') selected @endif>C</option>
                                    <option value="C-" @if($certificate->course_result == 'C-') selected @endif>C-
                                    </option>
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
                <h1 class="modal-title fs-5" id="exampleModalLabel">Certificate Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.certificateAdd') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Certificate ID</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <select class="form-control" name="certificate_id" id="certificate_id">
                                @foreach($enrolments as $enrolment)
                                    <option value="{{$enrolment->enrolment_id}}">{{$enrolment->enrolment_id}}</option>
                                @endforeach
                            </select>
                            {{--                            <input class="form-control" list="datalistOptions" id="certificate_id" name="certificate_id"--}}
                            {{--                                   required>--}}
                            {{--                            <datalist id="datalistOptions">--}}
                            {{--                                @foreach($enrolments as $enrolment)--}}
                            {{--                                    <option--}}
                            {{--                                        value="{{$enrolment->enrolment_id}}">{{$enrolment->enrolment_id}}</option>--}}
                            {{--                                @endforeach--}}
                            {{--                            </datalist>--}}
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Course Result</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <select class="form-control" id="course_result" name="course_result" required>
                                <option selected disabled value="">Select Course Result</option>
                                <option value="A+">A+</option>
                                <option value="A">A</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B">B</option>
                                <option value="B-">B-</option>
                                <option value="C+">C+</option>
                                <option value="C">C</option>
                                <option value="C-">C-</option>
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
