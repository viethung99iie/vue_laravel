<?php

namespace App\Services;

use App\Repositories\Interfaces\User\UserCatalogueRepositoryInterface as UserCatalogueRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class BaseService
 * @package App\Services
 */
class BaseService
{

    public function __construct(

    ){

    }


    public function updateStatus($request, $subFolder){
        DB::beginTransaction();
        try{
            $payload[$request->input('field')] = (($request->input('checked') == true)? 2 : 1 );
            $folder = 'Repositories'.'\\'.$subFolder;
            $interface = 'Repository';
            $class = loadClass($request->input('model'), $folder, $interface);
            $class->update($request->input('id'), $payload);

            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            // echo $e->getMessage();die();
            return false;
        }
    }

    // public function updateStatusAll($request, $subFolder){
    //     DB::beginTransaction();
    //     try{
    //         $payload[$request->input('field')] = $request->input('value');
    //         $folder = 'Repositories'.'\\'.$subFolder;
    //         $interface = 'Repository';
    //         $class = loadClass($request->input('model'), $folder, $interface);
    //         $class->updateByIds($request->input('ids'), $payload);


    //         DB::commit();
    //         return true;
    //     }catch(\Exception $e ){
    //         DB::rollBack();
    //         // Log::error($e->getMessage());
    //         // echo $e->getMessage();die();
    //         return false;
    //     }
    // }


}

