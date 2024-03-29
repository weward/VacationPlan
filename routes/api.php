<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HolidayPlansController;
use App\Models\HolidayPlan;

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
Route::bind('holidayplan', function ($id) {
    $ttl = config('cache.default_ttl');
    return Cache::remember("holiday_plan_{$id}", $ttl, function () use ($id) {
        return HolidayPlan::findOrFail($id);
    }); 
});

Route::middleware('auth:sanctum')->group(function() {
    Route::prefix('holiday-plans')->group(function () {
        Route::get('/', [HolidayPlansController::class, 'index'])->name('holiday-plans.index');
        Route::post('/', [HolidayPlansController::class, 'store'])->name('holiday-plans.store');
        Route::get('/{holidayplan}', [HolidayPlansController::class, 'show'])->name('holiday-plans.show');
        Route::put('/{holidayplan}', [HolidayPlansController::class, 'update'])->name('holiday-plans.update');
        Route::delete('/{holidayplan}', [HolidayPlansController::class, 'destroy'])->name('holiday-plans.destroy');
        Route::get('/{holidayplan}/pdf', [HolidayPlansController::class, 'generatePdf'])->name('holiday-plans.pdf');
    });

    Route::post('logout', [Authcontroller::class, 'logout'])->name('auth.logout');
});

Route::prefix('auth')->group(function() {
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('register', [AuthController::class, 'register'])->name('auth.register');
});
