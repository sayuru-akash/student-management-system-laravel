<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Module;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        if ($request->search == null) {
            return view('verify-certificate');
        } else {
            $certificate = Certificate::where('certificate_id', $request->search)->leftJoin('users', 'users.student_id', '=', 'certificates.student_id')->leftJoin('courses', 'courses.course_code', '=', 'certificates.course_code')->select('certificates.*', 'users.fname', 'users.lname', 'courses.course_name', 'courses.course_duration')->first();
            if (!isset($certificate->certificate_id)) {
                return view('verify-certificate')->with('error', 'Certificate not found');
            } else {
                return view('verify-certificate', ['certificate' => $certificate]);
            }
        }
    }

    public function generateTranscriptPDF(Request $request)
    {
        if ($request->id == null) {
            return view('verify-certificate');
        }

        $certificate = Certificate::where('certificate_id', $request->id)->leftJoin('users', 'users.student_id', '=', 'certificates.student_id')->leftJoin('courses', 'courses.course_code', '=', 'certificates.course_code')->select('certificates.*', 'users.fname', 'users.lname', 'courses.course_name', 'courses.course_duration', 'courses.course_year')->first();
        $modules = Module::where('course_code', $certificate->course_code)->get();
        $generated_at = now();

        $pdf = PDF::loadView('transcript', ['certificate' => $certificate,
            'generated_at' => $generated_at], ['modules' => $modules]);
        return $pdf->download('SITC Transcript.pdf');
    }
}
