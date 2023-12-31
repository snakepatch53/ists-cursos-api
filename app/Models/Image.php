<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ["image", "description"];

    protected $appends = ["image_url"];

    public function getImageUrlAttribute()
    {
        return asset("storage/app/public/img_images/" . $this->image);
    }
}
