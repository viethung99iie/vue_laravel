<?php

namespace App\Models;

use App\Traits\QueryScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCatalogue extends Model
{
    use HasFactory, QueryScope;


    protected $fillable = [
        'name',
        'description',
        'publish',
    ];

    protected $attributes = [
        'publish' => 2,
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'user_catalogue_id', 'id');
    }
}
