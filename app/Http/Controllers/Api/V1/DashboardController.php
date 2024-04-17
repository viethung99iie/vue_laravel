<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
    }

    public function getModule()
    {
        return response()->json([
            'data' => __('sidebar'),
        ], ResponseEnum::OK);
    }

    public function updateStatus(Request $request)
    {
        $model = $request->input('model');
        $subFolder = str_replace('Catalogue', '', $model);
        $folder = 'Services' . '\\' . $subFolder;
        $interface = 'Service';
        $class = loadClass($model, $folder, $interface);

        if ($class->updateStatus($request, $subFolder)) {
            return response()->json([
                'messages' => 'Cập nhật trạng thái thành công',
            ], 200);
        }

        return response()->json([
            'messages' => 'Cập nhật trạng không thái thành công',
        ], 500);
    }

    public function updateStatusAll(Request $request)
    {
        $model = $request->input('model');
        $subFolder = str_replace('Catalogue', '', $model);
        $folder = 'Services' . '\\' . $subFolder;
        $interface = 'Service';
        $class = loadClass($model, $folder, $interface);

        if ($class->updateStatusAll($request, $subFolder)) {
            return response()->json([
                'messages' => 'Cập nhật trạng thái thành công',
            ], 200);
        }
        return response()->json([
            'messages' => 'Cập nhật trạng không thái thành công',
        ], 500);
    }
}
