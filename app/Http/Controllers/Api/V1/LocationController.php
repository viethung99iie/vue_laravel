<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\DistrictRepositoryInterface as DistrictRepository;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public $provinceRepository;
    public $districtRepository;
    public function __construct(
        DistrictRepository $districtRepository,
        ProvinceRepository $provinceRepository
    ) {
        $this->provinceRepository = $provinceRepository;
        $this->districtRepository = $districtRepository;
    }


    public function province()
    {
        $userCatalogues = $this->provinceRepository->all();
        if ($userCatalogues->isEmpty()) {
            return response()->json(['message' => 'Không có dữ liệu'], 404);
        }
        return response()
            ->json(
                [
                    'message' => 'lấy dữ liêu thành công',
                    'data' => $userCatalogues,
                ],
                ResponseEnum::OK
            );
    }

    public function location(Request $request)
    {
        $locations = [];
        $repository = ($request->input('relation') == 'districts') ? 'provinceRepository' : 'districtRepository';
        $model = $this->{$repository}->findById(
            $request->input('id'),
            ['code', 'name'],
            [$request->input('relation')]
        );

        return response()->json([
            'message' => 'Truy xuất dữ liệu thành công',
            'data' => $model->{$request->input('relation')}
        ], 200);

    }
}
