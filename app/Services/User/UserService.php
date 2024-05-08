<?php

namespace App\Services\User;

use App\Services\BaseService;
use App\Repositories\Interfaces\User\UserRepositoryInterface as UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Services\Interfaces\User\UserServiceInterface;

class UserService extends BaseService implements UserServiceInterface
{

    protected $userRepository;
    protected $payload =
    [
        'email',
        'name',
        'password',
        'image',
        'phone',
        'description',
        'userCatalogueId',
        'provinceId',
        'districtId',
        'wardId',
        'address',
    ];
    protected $fieldSearch = ['name'];

    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function paginate($request)
    {
        $perpage = ($request->input('perpage')) ? $request->input('perpage') : 20;
        $condition = [
            'keyword' => $request->input('keyword'),
            'publish' => $request->input('publish'),
        ];
        $relation = [];
        $users = $this->userRepository->pagination(
            $perpage,
            $condition,
            $this->fieldSearch,
            $relation,
            // $extend
        );
        return $users;
    }

    public function create($request)
    {

        DB::beginTransaction();
        try {
            $payload = $request->only($this->payload);
            return $payload;
            $user = $this->userRepository->create($payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function update($id, $request)
    {

        DB::beginTransaction();
        try {
            $payload = $request->only($this->payload);
            $user = $this->userRepository->update($id, $payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function deleteAll($request)
    {

        DB::beginTransaction();
        try {
            $ids = explode(',', $request->input('ids'));
            $user = $this->userRepository->forceDeleteAll($ids);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->forceDelete($id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();
            die();
            return false;
        }
    }
}
