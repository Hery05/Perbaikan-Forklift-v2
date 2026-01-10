<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterSparepartController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\RepairRequestController;
use App\Http\Controllers\TechnicianTaskController;

/*
|--------------------------------------------------------------------------
| AUTH (WAJIB DI LUAR auth middleware)
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => redirect('/login'));

/*
|--------------------------------------------------------------------------
| AUTHENTICATED AREA
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD (SEMUA ROLE)
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | LAPORAN PERBAIKAN (ADMIN + OPERATOR)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin,operator')->group(function () {

        Route::get('/reports/repairs', [RepairRequestController::class, 'report'])
            ->name('reports.repairs');

        Route::get('/repair-requests/create', [RepairRequestController::class, 'create'])
            ->name('repair-requests.create');

        Route::post('/repair-requests', [RepairRequestController::class, 'store'])
            ->name('repair-requests.store');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {

        Route::resource('users', UserController::class)->except(['show']);

        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    });

    /*
    |--------------------------------------------------------------------------
    | COORDINATOR
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:coordinator')->group(function () {

        Route::get('/repair-requests', [RepairRequestController::class, 'index'])
            ->name('repair-requests.index');

        Route::get('/repair-requests/{id}/edit', [RepairRequestController::class, 'edit'])
            ->name('repair-requests.edit');

        Route::put('/repair-requests/{id}', [RepairRequestController::class, 'update'])
            ->name('repair-requests.update');

        Route::get('/repair-requests/{id}/assign', [RepairRequestController::class, 'assignForm'])
            ->name('repair-requests.assign.form');

        Route::post('/repair-requests/{id}/assign', [RepairRequestController::class, 'assign'])
            ->name('repair-requests.assign.store');
    });

    /*
    |--------------------------------------------------------------------------
    | TECHNICIAN
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:technician')
        ->prefix('tasks')
        ->name('tasks.')
        ->group(function () {

            Route::get('/', [TechnicianTaskController::class, 'index'])
                ->name('index');

            Route::get('/{id}', [TechnicianTaskController::class, 'show'])
                ->name('show');

            Route::post('/{id}/start', [TechnicianTaskController::class, 'start'])
                ->name('start');

            Route::post('/{id}/finish', [TechnicianTaskController::class, 'finish'])
                ->name('finish');

            Route::post('/{id}/finish1', [TechnicianTaskController::class, 'finish1'])
                ->name('finish1');

            Route::get('/{id}/requestSparepartForm', [TechnicianTaskController::class, 'requestSparepartForm'])
                ->name('requestSparepartForm');

            Route::get('/{id}/sparepart', [TechnicianTaskController::class, 'requestSparepartForm'])
                ->name('sparepart.form');

            Route::post('/{id}/sparepart', [TechnicianTaskController::class, 'storeSparepart'])
                ->name('sparepart.store');

            // gudang
            Route::post('/sparepart/{id}/approve', [SparepartController::class, 'approve'])
                ->name('sparepart.approve');

            Route::post('/sparepart/{id}/reject', [SparepartController::class, 'reject'])
                ->name('sparepart.reject');
        });

    /*
    |--------------------------------------------------------------------------
    | SPAREPART
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:sparepart')->group(function () {

        Route::get('/spareparts', [SparepartController::class, 'index'])
            ->name('spareparts.index');

        Route::post('/spareparts/{id}/{status}', [SparepartController::class, 'updateStatus'])
            ->name('spareparts.updateStatus');
    });
    
    //Master Sparepart
    Route::resource('spareparts', MasterSparepartController::class)
    ->middleware('auth');

    /*
    |--------------------------------------------------------------------------
    | REPORT
    |--------------------------------------------------------------------------
    */
    Route::get('/reports', [ReportController::class, 'index'])
        ->middleware('auth')
        ->name('reports.index');

    Route::get('/reports/pdf', [ReportController::class, 'pdf'])
        ->middleware('auth')
        ->name('reports.pdf');
});
