<?php

namespace App\Services\User;

use App\Services\BaseService;
use App\Repositories\Interfaces\User\UserCatalogueRepositoryInterface as UserCatalogueRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\UserCatalogue;
use App\Services\Interfaces\User\UserCatalogueServiceInterface;

class UserCatalogueService extends BaseService implements UserCatalogueServiceInterface
{

    protected $userCatalogueRepository;
    protected $payload = ['name', 'description'];
    protected $fieldSearch = ['name'];

    public function __construct(
        UserCatalogueRepository $userCatalogueRepository
    ){
       $this->userCatalogueRepository = $userCatalogueRepository;
    }

    public function paginate($request){
        $perpage = ($request->input('perpage')) ? $request->input('perpage') : 20;
        $condition = [
            'keyword' => $request->input('keyword'),
            'publish' => $request->input('publish'),
        ];
        $relation = ['users'];

        // $extend = [
        //     'orderBy' => ['id', 'desc']
        // ];
        $userCatalogues = $this->userCatalogueRepository->pagination(
            $perpage,
            $condition,
            $this->fieldSearch,
            $relation,
            // $extend
        );
        return $userCatalogues;

    }

    public function create($request){

        DB::beginTransaction();
        try{
            $payload = $request->only($this->payload);
            $userCatalogue = $this->userCatalogueRepository->create($payload);
            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }
    }


}
