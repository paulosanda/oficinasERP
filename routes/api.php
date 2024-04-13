<?php

use App\Http\Controllers\Admin\ClientAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VehicleController;
use App\Http\Middleware\InjectClientId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::delete('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum')
    ->name('logout');

Route::middleware(['auth:sanctum', 'ability:root,admin'])->group(function (){
   Route::prefix('admin')->group(function (){
      Route::prefix('/client')->group(function (){
          Route::post('/', [ClientAdminController::class, 'store'])
              ->name('admin.create.client');
          Route::get('/', [ClientAdminController::class, 'index'])
              ->name('admin.index.client');
          Route::post('/user/{client_id}', [UserAdminController::class, 'store'])
              ->name('admin.user.create');
      });
   });
});

Route::middleware(['auth:sanctum', 'ability:master,operador', InjectClientId::class])->group(function(){
    Route::prefix('client')->group(function (){
        Route::prefix('customer')->group(function (){
            Route::post('/', [CustomerController::class, 'store'])
                ->name('customer.create');
            Route::put('/',[CustomerController::class, 'update'])
                ->name('customer.update');
            Route::post('/vehicle', [VehicleController::class, 'store'])
                ->name('customer.vehicle.store');
        });
    });

});
