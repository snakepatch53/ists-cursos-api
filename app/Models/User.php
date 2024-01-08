<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "name",
        "lastname",
        "dni",
        "signature",
        "photo",
        "email",
        'password',
        "role",
        "description",
        "facebook"
    ];

    public static $_ROLES = [
        "Administrador",
        "Responsable",
        "Profesor"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ["photo_url", "signature_url"];

    public function getPhotoUrlAttribute()
    {
        return asset("storage/app/public/img_users/" . $this->photo);
    }

    public function getSignatureUrlAttribute()
    {
        return asset("storage/app/public/img_signature/" . $this->signature);
    }


    public function courseTeacher()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }
    public function courseResponsible()
    {
        return $this->hasMany(Course::class, 'responsible_id');
    }
}
