<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>
        SITC Campus - Final Transcript
    </title>
    <style>
        @page {
        size: 21cm 29.7cm;
        margin: 0;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>

<body style="margin: 0 !important; padding: 0 !important; background-image: url('./img/transcript-bg.png'); background-repeat: no-repeat; background-size: contain;">
@isset($certificate)
    @if ($certificate->count() < 1)
        <h3>The Certificate ID You Entered is Invalid</h3>
    @endif
    <!-- <div class="d-flex text-center aligns-items-center justify-content-center">
        <img class="" src="https://sitc.lk/wp-content/uploads/2021/11/photo_2021-11-23_18-40-47-300x92.png"
             width="200px">
    </div> -->
    <div class="mt-5 d-flex aligns-items-center justify-content-center">
        <div style="height: 80px;"></div>
        <h2 class="mt-5 p-4 text-center">
            <strong>
                Final Transcript
            </strong>
            <hr>
        </h2>
    </div>
    <div class="ps-5 pe-5">
        <h3>
            <strong>
                To Whom It May Concern:
            </strong>
        </h3>
        <p>
            This is to certify that <strong>{{$certificate->fallback_name}}</strong> has
            successfully completed the
            <strong>{{$certificate->course_name}}</strong> conducted by the SITC Campus in the academic year
            <strong>{{$certificate->course_year}}</strong> and achieved a final grade of <strong>{{$certificate->course_result}}</strong>.
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
            {{$certificate->created_at->format('Y-m-d')}}
            </br>
            <strong>
                Transcript Printed On:
            </strong>
            {{$generated_at->format('Y-m-d')}}
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
    <!-- <div class="mt-5 pt-5">
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
    </div> -->
    <div class="page-break" style="height: 200px;"></div>
    <div class="ps-5 pe-5">
        <h3>
            <strong> Programme :</strong> {{$certificate->course_name}} 
        </h3>
        <p>
            <strong>
                Units Completed:
            </strong>
        </p>
        <table style="border: 1px solid black; width: 100%;">
            <thead>
                <tr>
                    <th style="border: 1px solid black;">Module No:</th>
                    <th style="border: 1px solid black;">Module</th>
                </tr>
            </thead>
            <tbody>
                @foreach($modules as $module)
                <tr>
                    <th style="border: 1px solid black;">Module {{$loop->iteration}}</th>
                    <td style="border: 1px solid black;">{{$module->module_name}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <p class="mt-1">
            <strong>
                Grading Criteria:
            </strong>
        </p>
        <table style="border: 1px solid black; width: 100%;" class="lh-sm fs-sm">
            <thead>
                <tr>
                    <th style="border: 1px solid black;">Grade</th>
                    <th style="border: 1px solid black;">Mark Range</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid black;">A+</td>
                    <td style="border: 1px solid black;">90-100</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">A</td>
                    <td style="border: 1px solid black;">85-89</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">A-</td>
                    <td style="border: 1px solid black;">80-84</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">B+</td>
                    <td style="border: 1px solid black;">77-79</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">B</td>
                    <td style="border: 1px solid black;">73-76</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">B-</td>
                    <td style="border: 1px solid black;">70-72</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">C+</td>
                    <td style="border: 1px solid black;">65-69</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">C</td>
                    <td style="border: 1px solid black;">60-64</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">C-</td>
                    <td style="border: 1px solid black;">55-59</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">D</td>
                    <td style="border: 1px solid black;">50-54</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">F</td>
                    <td style="border: 1px solid black;">0-49</td>
                </tr>
            </tbody>
        </table>
    </div>
@endisset
</body>
</html>
