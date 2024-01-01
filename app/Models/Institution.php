<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "initials",
        "logo"
    ];

    protected $appends = ["logo_url"];

    public function getLogoUrlAttribute()
    {
        return asset("storage/app/public/img_logos/" . $this->logo);
    }
}
