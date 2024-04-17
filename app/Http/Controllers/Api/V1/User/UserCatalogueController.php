<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UserCatalogue\UserCatalogueStoreRequest;
use App\Http\Resources\UserCatalogueResource;
use App\Services\Interfaces\User\UserCatalogueServiceInterface as UserCatalogueService;
use Illuminate\Http\Request;

class UserCatalogueController extends Controller
{
    protected $userCatalogueService;

    public function __construct(UserCatalogueService $userCatalogueService)
    {
        $this->userCatalogueService = $userCatalogueService;
    }

    public function index(Request $request)
    {
        $userCatalogues = $this->userCatalogueService->paginate($request);
        if ($userCatalogues->isEmpty()) {
            return response()->json(['message' => 'Không có dữ liệu'], 404);
        }
        return response()
            ->json($userCatalogues, ResponseEnum::OK);
    }

    public function store(UserCatalogueStoreRequest $request)
    {
        if ($this->userCatalogueService->create($request)) {
            return response()->json([
                'message' => 'Thêm mới bản ghi thành công'
            ], ResponseEnum::OK);
        }
        return response()->json([
            'message' => 'Đã có lỗi xảy ra, hãy thử lại'
        ], ResponseEnum::BAD_REQUEST);
    }

    public function deteleAll(Request $request)
    {
        if ($this->userCatalogueService->deleteAll($request)) {
            return response()->json([
                'message' => 'Xóa dữ liệu thành công!!'
            ], ResponseEnum::OK);
        }
        return response()->json([
            'message' => 'Đã có lỗi xảy ra, hãy thử lại'
        ], ResponseEnum::BAD_REQUEST);
    }
}
