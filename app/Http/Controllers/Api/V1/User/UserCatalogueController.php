<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\User\UserCatalogueStoreRequest;
use App\Http\Resources\UserCatalogueResource;
use App\Repositories\User\UserCatalogueRepository;
use App\Services\Interfaces\User\UserCatalogueServiceInterface as UserCatalogueService;
use Illuminate\Http\Request;

class UserCatalogueController extends Controller
{
    protected $userCatalogueService;
    protected $userCatalogueRepository;

    public function __construct(
        UserCatalogueService $userCatalogueService,
        UserCatalogueRepository $userCatalogueRepository,
    ) {
        $this->userCatalogueService = $userCatalogueService;
        $this->userCatalogueRepository = $userCatalogueRepository;
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

    public function all()
    {
        $userCatalogues = $this->userCatalogueRepository->all();
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

    public function update($id, Request $request)
    {
        if ($this->userCatalogueService->update($id, $request)) {
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

    public function read($id)
    {
        $user = $this->userCatalogueRepository->findById($id);
        return new UserCatalogueResource($user);
    }

    public function destroy($id)
    {
        if ($this->userCatalogueService->destroy($id)) {
            return response()->json([
                'message' => 'Xóa dữ liệu thành công!!'
            ], ResponseEnum::OK);
        }
        return response()->json([
            'message' => 'Đã có lỗi xảy ra, hãy thử lại'
        ], ResponseEnum::BAD_REQUEST);
    }
}
