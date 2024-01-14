<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    public static $_STATES = [
        "Inscrito",
        "Aprobado",
        "Reprobado",
        "Baneado"
    ];


    protected $fillable = [
        "state",
        "certificate_code",
        "student_id",
        "course_id"
    ];

    protected $appends = [
        "certificate_url"
    ];

    public function getCertificateUrlAttribute()
    {
        // route web (no api) to get certificate/{id}
        return route("certificate", ["id" => $this->id]);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
