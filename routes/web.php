<?php

use App\Http\Controllers\Company\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\Admin\CompanyController;
use App\Http\Controllers\Web\Company\CustomerController;
use App\Http\Middleware\CompanyMaster;
use App\Http\Middleware\IsUserEnable;
use App\Http\Middleware\SystemAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('admin')->middleware(SystemAdmin::class)->group(function () {
    Route::prefix('company')->group(function () {
        Route::get('/', [CompanyController::class, 'admin'])->name('company.admin');
        Route::get('/create', [CompanyController::class, 'create'])->name('company.create');
        Route::get('/user/create/{company_id}', [CompanyController::class, 'createUser'])->name('company.create.user');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(IsUserEnable::class)->group(function () {
        Route::middleware(CompanyMaster::class)->group(function () {
            Route::prefix('user')->group(function () {
                Route::get('/', [UserController::class, 'index'])->name('company.user.index');
                Route::get('/create', [UserController::class, 'create'])->name('web.company.user.create');
            });
        });
        Route::prefix('customer')->group(function () {
            Route::get('/', [CustomerController::class, 'index'])->name('web.company.customer.index');
            Route::get('/create', [CustomerController::class, 'create'])->name('web.customer.create');
        });
    });
});

require __DIR__.'/auth.php';
