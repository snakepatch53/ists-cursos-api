<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        "dni",
        "name",
        "lastname",
        "sex",
        "instruction",
        "address",
        "email",
        "cellphone",
        "phone",
        "description",
        "entity_name",
        "entity_post",
        "entity_address",
        "entity_phone"
    ];

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }
}
