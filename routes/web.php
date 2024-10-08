<?php

use App\Http\Controllers\Company\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\Admin\CompanyController;
use App\Http\Controllers\Web\Company\CheckupController;
use App\Http\Controllers\Web\Company\CustomerController;
use App\Http\Controllers\Web\Company\QuoteController;
use App\Http\Controllers\Web\Company\ScheduledServicesController;
use App\Http\Middleware\CompanyMaster;
use App\Http\Middleware\IsActiveCompany;
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

//Rotas Company
Route::middleware(['auth', isActiveCompany::class])->group(function () {
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
        Route::prefix('checkup')->group(function () {
            Route::get('/create/{customerId}', [CheckupController::class, 'create'])->name('web.checkup.create');
            Route::get('/', [CheckupController::class, 'index'])->name('web.checkup.index');
            Route::get('/{checkupId}', [CheckupController::class, 'show'])->name('web.checkup.show');
        });
        Route::prefix('quote')->group(function () {
            Route::get('/', [QuoteController::class, 'index'])->name('web.quote.index');
            Route::get('/{quoteId}', [QuoteController::class, 'show'])->name('web.quote.show');
            Route::get('/create/{checkupId}', [QuoteController::class, 'create'])->name('web.quote.create');
        });
        Route::prefix('schedule')->group(function () {
            Route::get('/', [ScheduledServicesController::class, 'index'])->name('web.schedule.index');
            Route::get('/{scheduleId}', [ScheduledServicesController::class, 'show'])->name('web.schedule.show');
            Route::get('/create/{customerId}', [ScheduledServicesController::class, 'create'])->name('web.schedule.create');
        });
    });
});

require __DIR__.'/auth.php';
