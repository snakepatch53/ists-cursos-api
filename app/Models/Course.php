<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        "image",
        "name",
        "duration",
        "date_start",
        "date_end",
        "quota",
        "whatsapp",
        "description",
        "published",
        "teacher_id",
        "responsible_id",
        "template_id",
    ];

    protected $appends = [
        "image_url",
        "date_start_str",
        "date_end_str",
        "course_started",
        "course_finished"
    ];

    public function getImageUrlAttribute()
    {
        return asset("storage/app/public/img_courses/" . $this->image);
    }

    public function getDateStartStrAttribute()
    {
        return Carbon::parse($this->date_start)->locale('es_ES')->isoFormat('dddd, D [de] MMMM [del] YYYY');
    }

    public function getDateEndStrAttribute()
    {
        return Carbon::parse($this->date_end)->locale('es_ES')->isoFormat('dddd, D [de] MMMM [del] YYYY');
    }

    public function getCourseStartedAttribute()
    {
        return Carbon::parse($this->date_start)->isPast();
    }

    public function getCourseFinishedAttribute()
    {
        return Carbon::parse($this->date_end)->isPast();
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }
}
