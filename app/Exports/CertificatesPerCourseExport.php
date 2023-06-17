<?php

namespace App\Exports;

use App\Models\Certificate;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class CertificatesPerCourseExport implements FromQuery
{
    use Exportable;

    public function __construct(string $course_code)
    {
        $this->course_code = $course_code;
    }

    public function query()
    {
        return Certificate::where('course_code', $this->course_code);
    }
}