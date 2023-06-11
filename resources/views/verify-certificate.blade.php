@extends('layout.app')

@section('content')
    <div class="container">
        <!-- ======= Results Section ======= -->
        <section id="hero" class="hero d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 d-flex flex-column justify-content-center">
                        <h1 data-aos="fade-up">SITC Campus</h1>
                        <h3 data-aos="fade-up" data-aos-delay="400">Validate Your Certificate</h3>
                        <div data-aos="fade-up" data-aos-delay="600">
                            <div class="text-center text-lg-start">
                                @if(session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                @if(session()->has('err-message'))
                                    <div class="alert alert-danger">
                                        <span>{{ session()->get('err-message') }}</span>
                                    </div>
                                @endif
                                @isset($certificate)
                                    @if($certificate->count() < 1)
                                        <div class="alert alert-danger">
                                            <span>Entered Certificate ID is Invalid</span></br>
                                        </div>
                                    @else
                                        <div class="alert alert-success">
                                            <span>Entered Certificate ID is Valid</span></br>
                                        </div>
                                    @endif
                                @endisset
                                <form class="mt-2" action="{{ route('verifyCertificate') }}" method="GET">
                                    <input type="text" class="form-control form-control-lg" name="search"
                                           placeholder="Enter Certificate ID" required
                                           @isset($certificate) value="{{$certificate->certificate_id}}"
                                           readonly @endisset>
                                    @if (!@isset ($certificate))
                                        <button type="submit" class="border-0 h-100 btn-get-started scrollto d-inline-flex
                                    align-items-center justify-content-center align-self-center">
                                            <span>Verify</span><i class="bi bi-arrow-right"></i>
                                        </button>
                                    @endif
                                </form>
                                <br>
                                <br>
                                @isset ($certificate)
                                    <table class="table table-responsive">
                                        <tr>
                                            <td>
                                                <strong>Certificate ID</strong>
                                            </td>
                                            <td>
                                                {{$certificate->certificate_id}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Student ID</strong>
                                            </td>
                                            <td>
                                                {{$certificate->student_id}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Student Name</strong>
                                            </td>
                                            <td>
                                                {{$certificate->fname . ' ' . $certificate->lname}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Course Name</strong>
                                            </td>
                                            <td>
                                                {{$certificate->course_name}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Course Duration</strong>
                                            </td>
                                            <td>
                                                {{$certificate->course_duration}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Course Result</strong>
                                            </td>
                                            <td>
                                                {{$certificate->course_result}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Issued On</strong>
                                            </td>
                                            <td>
                                                {{$certificate->created_at}}
                                            </td>
                                        </tr>
                                    </table>
                                    <a class="btn btn-warning fw-bold"
                                       href="{{ url('generate-transcript?id=' . $certificate->certificate_id) }}">
                                        Download Transcript</a>
                                @endisset
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 text-center" data-aos="zoom-out" data-aos-delay="200">
                        <img src="{{asset('/img/hero-img-4.png')}}" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </section><!-- End Results Section -->
    </div>
@endsection
