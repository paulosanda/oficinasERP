<?php

use App\Http\Controllers\Admin\CompanyAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\VehicleController;
use App\Http\Middleware\InjectCompanyId;
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
      Route::prefix('/company')->group(function (){
          Route::post('/', [CompanyAdminController::class, 'store'])
              ->name('admin.create.company');
          Route::get('/', [CompanyAdminController::class, 'index'])
              ->name('admin.index.company');
          Route::put('/',[CompanyAdminController::class, 'update'])
              ->name('admin.company.update');
          Route::get('/company/roles', [RoleController::class, 'companyIndex'])
              ->name('admin.company.rules.index');
          Route::post('/user/{companyId}', [UserAdminController::class, 'store'])
              ->name('admin.user.create');
      });
   });
});

Route::middleware(['auth:sanctum', 'ability:master,operador', InjectCompanyId::class])->group(function(){
    Route::prefix('company')->group(function (){
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
