<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('virtual-meters.index');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('virtual-meters', [App\Http\Controllers\VirtualMeterController::class, 'index'])->name('virtual-meters.index');
Route::get('virtual-meters/{virtualMeter}/{variable}', [App\Http\Controllers\VirtualMeterController::class, 'show'])->name('virtual-meters.show');
Route::post('virtual-meters/search/{virtualMeter}/{variable}/{from}/{to}', [App\Http\Controllers\VirtualMeterController::class, 'getMeterData'])->name('virtual-meters.search');
Route::get('query', [App\Http\Controllers\VirtualMeterController::class, 'showQueryPage'])->name('virtual-meters.showQuery');
Route::post('query/results', [App\Http\Controllers\VirtualMeterController::class, 'getQueryResults'])->name('virtual-meters.queryResults');

Route::get('variables', [App\Http\Controllers\ConvergeVariableController::class, 'index'])->name('variables.index');