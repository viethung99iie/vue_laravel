<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{

    protected $table = 'districts';
    protected $primaryKey = 'code';
    public $incrementing = false;

    public function wards(): HasMany
    {
        return $this->hasMany(Ward::class, 'district_code', 'code');
    }

    public function provinces(): BelongsTo
    {
        return $this->BelongsTo(Province::class, 'province_code', 'code');
    }
}
