<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>
        SITC Campus - Final Transcript
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>

<body class="container mt-5">
@isset($certificate)
    @if ($certificate->count() < 1)
        <h3>The Certificate ID You Entered is Invalid</h3>
    @endif
    <div class="d-flex text-center aligns-items-center justify-content-center">
        <img class="" src="https://sitc.lk/wp-content/uploads/2021/11/photo_2021-11-23_18-40-47-300x92.png"
             width="200px">
    </div>
    <div class="d-flex aligns-items-center justify-content-center">
        <h2 class="p-4 text-center">
            <strong>
                Sciences and Information Technology City Campus - Final Transcript
            </strong>
            <hr>
        </h2>
    </div>
    <div>
        <h3>
            <strong>
                To Whom It May Concern:
            </strong>
        </h3>
        <p>
            This is to certify that <strong>{{$certificate->fname . ' ' . $certificate->lname}}</strong> has
            successfully completed the
            <strong>{{$certificate->course_name}}</strong> conducted by the SITC Campus in the academic year
            <strong>2022</strong> and achieved a final grade of <strong>{{$certificate->course_result}}</strong>.
        </p>
        <p>
            <strong>
                Student ID:
            </strong>
            {{$certificate->student_id}}
            </br>
            <strong>
                Certificate ID:
            </strong>
            {{$certificate->certificate_id}}
            </br>
            <strong>
                Issued On:
            </strong>
            {{$certificate->created_at}}
            </br>
            <strong>
                Generated On:
            </strong>
            {{$generated_at}}
        </p>
        <p class="mt-5">
            Thank you,
            </br>
            <img src="https://sitc.lk/wp-content/uploads/2022/10/sign.png" width="120">
            </br>
            <strong>
                M.K.W. Isuru Perera,
                </br>
                Academic Director,
                </br>
                Sciences and Information Technology City Campus
            </strong>
        </p>
    </div>
    <div class="mt-5 pt-5">
        <hr>
        <div class="text-center">
            Tel: +94 81-3164986, +94 81-3137618 | Gov. Reg. No: PV 00245050
        </div>
        <div class="text-center">
            Address: 46, Court Road, Gampola, Sri Lanka
        </div>
        <div class="text-center">
            Web: www.sitc.lk | Email: info@sitc.lk
        </div>
    </div>
@endisset
</body>
</html>
