<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // PDF Preview -- as noted in the README.md
    $data = App\Models\HolidayPlan::with(['user'])->find(1);

    return view('pdf.holiday-plan', ['data' => $data]);
});
