<?php

namespace App\Repositories;

use App\Repositories\Interfaces\DistrictRepositoryInterface;
use App\Repositories\BaseRepository;
use App\Models\District;

class DistrictRepository extends BaseRepository implements DistrictRepositoryInterface
{

    protected $model;

    public function __construct(
        District $model
    ) {
        $this->model = $model;
    }
}
