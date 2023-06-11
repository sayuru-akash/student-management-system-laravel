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
            <h1 class="m-2 text-uppercase font-monospace fs-2">Manage Students</h1>
            <a data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-sm btn-primary w-25">Add New Student</a>
        </div>
        <form class="mt-2" action="{{ route('admin.users') }}" method="GET">
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
                    <th scope="col">St. ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">NIC</th>
                    <th scope="col">Email</th>
                    <th scope="col" class="d-sm-none d-md-none d-lg-block">Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach($users as $user)
                    <tr>
                        <th scope="row">{{ $loop->index }}</th>
                        <td>{{ $user->student_id }}</td>
                        <td>{{ $user->fname . ' ' . $user->lname }}</td>
                        <td>{{ $user->nic }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="d-sm-none d-md-none d-lg-block">
                            <a data-bs-toggle="modal" data-bs-target="#viewModal{{ $user->id }}"
                               class="btn btn-sm btn-primary w-25">View</a>
                            <a data-bs-toggle="modal" data-bs-target="#editModal{{ $user->id }}"
                               class="btn btn-sm btn-warning w-25">Edit</a>
                            <a href="/admin/users/delete?id={{ $user->id }}"
                               class="btn btn-sm btn-danger w-25">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
</div>

@foreach($users as $user)
    <!-- View Data Modal -->
    <div class="modal fade" id="viewModal{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Student Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">First Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="fname" value="{{$user->fname}}" disabled>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Last Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="lname" value="{{$user->lname}}" disabled>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">NIC</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="nic" value="{{$user->nic}}" disabled>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="email" value="{{$user->email}}" disabled>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Phone</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="phone" value="{{$user->phone}}" disabled>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Birthday</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="birthday" value="{{$user->birthday}}"
                                   disabled>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Gender</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="gender" value="{{$user->gender}}" disabled>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Address</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="address" value="{{$user->address}}" disabled>
                        </div>
                    </div>
                    <br>
                    @if (!$user->enrolments->isEmpty())
                    <table class="table table-striped">
                        <span class="text-black fw-bold">Enrolments</span>
                        <thead>
                            <tr>
                                <th class="text-muted">Code</th>
                                <th class="text-muted">Programme Name</th>
                                <th class="text-muted">Year</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach ($user->enrolments as $enrolment)
                                    <tr>
                                        <td>{{ $enrolment->course_code }}</td>
                                        <td>{{ $enrolment->course_name }}</td>
                                        <td>{{ $enrolment->course_year }}</td>
                                    </tr>
                                @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Data Modal -->
    <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Student Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.userModify') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" value="{{$user->id}}">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="col-form-label">First Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" class="form-control" name="fname" value="{{$user->fname}}" required>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="col-form-label">Last Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" class="form-control" name="lname" value="{{$user->lname}}" required>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="col-form-label">NIC</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" class="form-control" maxlength="12" name="nic" value="{{$user->nic}}" required>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="col-form-label">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="email" class="form-control" name="email" value="{{$user->email}}" required>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="col-form-label">Phone</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" class="form-control" maxlength="10" name="phone" value="{{$user->phone}}" required>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="col-form-label">Birthday</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="date" class="form-control" name="birthday" value="{{$user->birthday}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="col-form-label">Gender</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <select class="form-control" id="gender" name="gender">
                                    <option disabled value="">Select Gender</option>
                                    <option value="Male" @if($user->gender == "Male") selected @endif>Male</option>
                                    <option value="Female" @if($user->gender == "Female") selected @endif>Female
                                    </option>
                                    <option value="Decline to answer"
                                            @if($user->gender == "Decline to answer") selected @endif>Decline to answer
                                    </option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="col-form-label">Address</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" class="form-control" name="address" value="{{$user->address}}">
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
                <h1 class="modal-title fs-5" id="exampleModalLabel">Student Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.userAdd') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">First Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="fname" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Last Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="lname" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">NIC</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" maxlength="12" name="nic" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="email" class="form-control" name="email" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Phone</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" maxlength="10" name="phone" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Birthday</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="date" class="form-control" name="birthday" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Gender</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <select class="form-control" id="gender" name="gender" required>
                                <option selected disabled value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="col-form-label">Password</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="password" class="form-control" name="password" required>
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
