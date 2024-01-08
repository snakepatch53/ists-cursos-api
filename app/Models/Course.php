<?php

namespace App\Models;

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

    protected $appends = ["image_url"];

    public function getImageUrlAttribute()
    {
        return asset("storage/app/public/img_courses/" . $this->image);
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
