<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\DashboardController;
use App\Http\Controllers\Api\V1\User\UserCatalogueController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('dashboard/getModule', [DashboardController::class, 'getModule'])->name('dashboard.module');

    // UserCatalogue
    Route::get('/user/catalogue', [UserCatalogueController::class, 'index'])->name('user.catalogue.index');
    Route::get('/user/catalogue/{id}', [UserCatalogueController::class, 'read'])->name('user.catalogue.detail')->where(['id' => '[0-9]+']);
    Route::post('/user/catalogue/store', [UserCatalogueController::class, 'store'])->name('user.catalogue.store');
    Route::put('/user/catalogue/update/{id}', [UserCatalogueController::class, 'update'])->name('user.catalogue.update')->where(['id' => '[0-9]+']);
    Route::delete('/user/catalogue/deteleAll', [UserCatalogueController::class, 'deteleAll'])->name('user.catalogue.detele.all');
    Route::delete('/user/catalogue/delete/{id}', [UserCatalogueController::class, 'destroy'])->name('user.catalogue.destroy');


    // CHANG STATUS
    Route::put('/update/status', [DashboardController::class, 'updateStatus'])->name('dashboard.update.status');
    Route::put('/update/status/all', [DashboardController::class, 'updateStatusAll'])->name('dashboard.update.status.all');
});


Route::post('auth/login', [AuthController::class, 'login'])->name('login');
