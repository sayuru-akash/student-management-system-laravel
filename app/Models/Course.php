<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_code',
        'course_name',
        'course_category',
        'course_fee',
        'course_start_date',
        'course_duration',
        'course_year',
        'course_status',
    ];
}
