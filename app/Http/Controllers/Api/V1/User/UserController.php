<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\User\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Repositories\User\UserRepository;
use App\Services\Interfaces\User\UserServiceInterface as UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    protected $userRepository;

    public function __construct(
        UserService $userService,
        UserRepository $userRepository,
    ) {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $users = $this->userService->paginate($request);
        if ($users->isEmpty()) {
            return response()->json(['message' => 'Không có dữ liệu'], 404);
        }
        return response()
            ->json($users, ResponseEnum::OK);
    }

    public function store(UserStoreRequest $request)
    {
        if ($this->userService->create($request)) {
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
        if ($this->userService->update($id, $request)) {
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
        if ($this->userService->deleteAll($request)) {
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
        $user = $this->userRepository->findById($id);
        return new UserResource($user);
    }

    public function destroy($id)
    {
        if ($this->userService->destroy($id)) {
            return response()->json([
                'message' => 'Xóa dữ liệu thành công!!'
            ], ResponseEnum::OK);
        }
        return response()->json([
            'message' => 'Đã có lỗi xảy ra, hãy thử lại'
        ], ResponseEnum::BAD_REQUEST);
    }
}
