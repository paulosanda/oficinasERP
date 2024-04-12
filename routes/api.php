<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::delete('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])
    ->middleware('auth:sanctum')
    ->name('logout');

Route::middleware(['auth:sanctum', 'ability:root,admin'])->group(function (){
   Route::prefix('admin')->group(function (){
      Route::prefix('/client')->group(function (){
          Route::post('/', [\App\Http\Controllers\Admin\ClientAdminController::class, 'store'])
              ->name('admin.create.client');
          Route::get('/', [\App\Http\Controllers\Admin\ClientAdminController::class, 'index'])
              ->name('admin.index.client');
          Route::post('/user/{client_id}', [\App\Http\Controllers\Admin\UserAdminController::class, 'store'])
              ->name('admin.user.create');
      });
   });
});

Route::middleware(['auth:sanctum', 'ability:master,operador'])->group(function(){
    Route::prefix('client')->group(function (){
        Route::prefix('customer')->group(function (){
            Route::post('/', [\App\Http\Controllers\CustomerController::class, 'store'])
                ->name('customer.create');
            Route::put('/',[\App\Http\Controllers\CustomerController::class, 'update'])
                ->name('customer.update');
        });
    });

});
