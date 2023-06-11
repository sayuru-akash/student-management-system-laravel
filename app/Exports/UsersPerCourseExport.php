<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Enrollment;
use App\Models\Course;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class UsersPerCourseExport implements FromQuery
{
    use Exportable;

    public function __construct(string $course_code)
    {
        $this->course_code = $course_code;
    }

    public function query()
    {
        return User::query()->leftJoin('enrollments', 'enrollments.user_id', '=', 'users.id')->where('enrollments.enrollment_status', '1')->leftJoin('courses', 'courses.id', '=', 'enrollments.course_id')->where('courses.course_code', $this->course_code)->select('users.*', 'courses.course_name', 'courses.course_code', 'courses.course_year');
    }
}