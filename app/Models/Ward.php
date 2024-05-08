<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ward extends Model
{

    protected $table = 'wards';
    protected $primaryKey = 'code';
    public $incrementing = false;


    public function districts(): BelongsTo
    {
        return $this->BelongsTo(District::class, 'district_code', 'code');
    }
}
