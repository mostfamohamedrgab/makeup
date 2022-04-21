<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    
    protected $guarded = [];

    
    protected $hidden = [
        'password',
        'remember_token',
    ];

   
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function address()
    {
        return $this->hasMany(Adress::class);
    }


    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_user', 'user_id', 'service_id')->withPivot('price','time');
    }

    public function gallerey()
    {
        return $this->hasMany(BeautyGallery::class);
    }
}
