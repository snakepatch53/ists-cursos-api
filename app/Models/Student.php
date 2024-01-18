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

    public static $_INSTRUCTIONS = ["Primaria", "Secundaria", "Técnico", "Superior"];
    public static $_SEXS = ["Masculino", "Femenino", "Otro"];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    }

    public function setLastnameAttribute($value)
    {
        $this->attributes['lastname'] = ucwords(strtolower($value));
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }
}
