<?php

use App\Http\Controllers\Admin\CompanyAdminController;
use App\Http\Controllers\Admin\MessageTypeAdminController;
use App\Http\Controllers\Admin\SchedulableServiceAdminController;
use App\Http\Controllers\Admin\SystemServiceAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckupController;
use App\Http\Controllers\CheckupObservationTypeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ScheduledServiceController;
use App\Http\Controllers\UserController;
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

/**
 * Rotas administrativas
 */
Route::middleware(['auth:sanctum', 'ability:root,admin'])->group(function (){
   Route::prefix('admin')->group(function (){

      Route::get('/roles',  [RoleController::class, 'adminIndex'])->name('admin.roles.index');

      Route::prefix('/company')->group(function (){
          Route::post('/', [CompanyAdminController::class, 'store'])->name('admin.create.company');
          Route::get('/', [CompanyAdminController::class, 'index'])->name('admin.index.company');
          Route::put('/',[CompanyAdminController::class, 'update'])->name('admin.company.update');

          Route::post('/user/{companyId}', [UserAdminController::class, 'store'])->name('admin.user.create');
      });

      Route::get('/schedulable-services', [SchedulableServiceAdminController::class, 'index'])->name('schedulable_services.index');
      Route::post('/schedulable-services', [SchedulableServiceAdminController::class, 'store'])->name('scheculable_services.store');
      Route::patch('/schedulable-services/{schedulableServiceId}', [SchedulableServiceAdminController::class, 'update'])->name('schedulable_services.update');

      Route::prefix('messages')->group(function (){
         Route::get('/', [MessageTypeAdminController::class, 'index'])->name('message.index');
         Route::post('/', [MessageTypeAdminController::class, 'store'])->name('message.store');
         Route::put('/{messageTypeId}', [MessageTypeAdminController::class, 'update'])->name('message.update');
      });

//      system service routes
    Route::prefix('system-service')->group(function (){
         Route::get('/', [SystemServiceAdminController::class, 'index'])->name('system_service.index');
         Route::post('/', [SystemServiceAdminController::class, 'store'])->name('system_service.store');
         Route::put('/{systemServiceID}', [SystemServiceAdminController::class, 'update'])->name('system_service.update');
       });
   });
});

//Rotas company ability master
Route::middleware(['auth:sanctum', 'ability:master', InjectCompanyId::class])->group(function (){
    Route::prefix('company')->group(function (){
       Route::prefix('user')->group(function (){
          Route::post('/', [UserController::class, 'store'])->name('company_user.store');
          Route::delete('/{userId}',[UserController::class,'delete'])->name('company_user.delete');
       });
    });
});

/**
 * Rotas de companies
 */
Route::middleware(['auth:sanctum', 'ability:master,operator', InjectCompanyId::class])->group(function(){
    Route::prefix('company')->group(function (){
        Route::prefix('customer')->group(function (){
            Route::post('/', [CustomerController::class, 'store'])->name('customer.create');
            Route::put('/',[CustomerController::class, 'update'])->name('customer.update');
            Route::post('/vehicle', [VehicleController::class, 'store'])->name('customer.vehicle.store');
            Route::post('/checkup', [CheckupController::class, 'store'])->name('customer.checkup.store');
            Route::get('/checkup-observation-types', [CheckupObservationTypeController::class, 'index'])->name('checkup_observation.index');

            Route::prefix('quote')->group(function (){
               Route::post('/', [QuoteController::class, 'store'])->name('quote.store');
            });
            Route::prefix('schedulable')->group(function (){
                Route::get('/services', [ScheduledServiceController::class, 'listService'])->name('schedulable_services.list');

            });
            Route::prefix('schedule-service')->group(function (){
                Route::post('/', [ScheduledServiceController::class, 'store'])->name('schedule_service.store');
                Route::get('/', [ScheduledServiceController::class, 'index'])->name('schedule_service.index');
            });

        });
    });

});

/**
 * Rotas administrativas e companies
 */
Route::middleware(['auth:sanctum', 'ability:root,admin,master',  InjectCompanyId::class])->group(function (){
   Route::prefix('user')->group(function (){
      Route::get('/', [UserAdminController::class, 'index'])->name('user.index');
      Route::put('/{user_id}', [UserAdminController::class, 'update'])->name('user.update');
   });

    Route::get('/roles', [RoleController::class, 'companyIndex'])->name('admin.company.rules.index');
});
