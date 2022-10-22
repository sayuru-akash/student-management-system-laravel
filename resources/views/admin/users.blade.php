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
        <div class="p-2 mb-4 text-center bg-light">
            <h1 class="m-2 text-uppercase font-monospace fs-2">Manage Students</h1>
        </div>
        <div class="table-responsive">
            <table class="table table-primary table-striped table-hover">
                <thead>
                <tr class="table-dark">
                    <th scope="col">#</th>
                    <th scope="col">St. ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">NIC</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
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
                        <td>{{ $user->phone }}</td>
                        <td class="d-sm-none d-md-none d-lg-block">
                            <a href="/admin/users/{{ $user->id }}/view" class="btn btn-sm btn-primary w-25">View</a>
                            <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-sm btn-warning w-25">Edit</a>
                            <a href="/admin/users/{{ $user->id }}/delete" class="btn btn-sm btn-danger w-25">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            {!! $users->links() !!}
        </div>
    </div>
</div>
@include('includes.minFooter')
</body>
</html>
