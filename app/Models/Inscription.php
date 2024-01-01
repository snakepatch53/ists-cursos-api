<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    protected $fillable = [
        "approval",
        "certificate_code",
        "student_id",
        "course_id"
    ];

    public function students()
    {
        return $this->belongsTo(Student::class);
    }

    public function courses()
    {
        return $this->belongsTo(Course::class);
    }
}
