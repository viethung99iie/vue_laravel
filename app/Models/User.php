<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\QueryScope;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, QueryScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'address',
        'birthday',
        'description',
        'district_id',
        'email',
        'image',
        'name',
        'password',
        'phone',
        'province_id',
        'user_catalogue_id',
        'ward_id',
        'publish',
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

    protected $attributes = [
        'publish' => 1,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function user_catalogues(){
        return $this->belongsTo(UserCatalogue::class, 'user_catalogue_id', 'id');
    }
}
