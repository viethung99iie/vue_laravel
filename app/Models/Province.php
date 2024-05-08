<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{

    protected $table = 'provinces';
    protected $primaryKey = 'code';
    public $incrementing = false;

    public function districts(): HasMany
    {
       return  $this->hasMany(District::class, 'province_code', 'code');
    }
}
