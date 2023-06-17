<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'certificate_id',
        'student_id',
        'course_code',
        'course_result',
        'fallback_name',
    ];
}
