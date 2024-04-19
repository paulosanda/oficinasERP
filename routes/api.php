<?php

use App\Http\Controllers\Admin\CompanyAdminController;
use App\Http\Controllers\Admin\SchedulableServiceAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckupController;
use App\Http\Controllers\CheckupObservationTypeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\QuoteController;
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
       Route::get('/schedulable-services', [SchedulableServiceAdminController::class, 'index'])
           ->name('schedulable_services.index');
       Route::post('/', [SchedulableServiceAdminController::class, 'store'])
           ->name('scheculable_services.store');
       Route::patch('/{schedulableServiceId}', [SchedulableServiceAdminController::class, 'update'])
            ->name('schedulable_services.update');
   });
});

Route::middleware(['auth:sanctum', 'ability:master,operator', InjectCompanyId::class])->group(function(){
    Route::prefix('company')->group(function (){
        Route::prefix('customer')->group(function (){
            Route::post('/', [CustomerController::class, 'store'])
                ->name('customer.create');
            Route::put('/',[CustomerController::class, 'update'])
                ->name('customer.update');
            Route::post('/vehicle', [VehicleController::class, 'store'])
                ->name('customer.vehicle.store');
            Route::post('/checkup', [CheckupController::class, 'store'])
                ->name('customer.checkup.store');
            Route::get('/checkup-observation-types', [CheckupObservationTypeController::class, 'index'])
                ->name('checkup_observation.index');
            Route::prefix('quote')->group(function (){
               Route::post('/', [QuoteController::class, 'store'])
                   ->name('quote.store');
            });
        });
    });

});
