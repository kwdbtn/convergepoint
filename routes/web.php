<?php

use App\Http\Controllers\ConvergeVariableController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FeederController;
use App\Http\Controllers\MeterLocationController;
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
Route::get('virtual-meters/meter/{virtualMeter}/edit', [App\Http\Controllers\VirtualMeterController::class, 'edit'])->name('virtual-meters.edit');
Route::post('virtual-meters', [App\Http\Controllers\VirtualMeterController::class, 'store'])->name('virtual-meters.store');
Route::put('virtual-meters/meter/{virtualMeter}/update', [App\Http\Controllers\VirtualMeterController::class, 'update'])->name('virtual-meters.update');
Route::post('virtual-meters/search/{virtualMeter}/{variable}/{from}/{to}', [App\Http\Controllers\VirtualMeterController::class, 'getMeterData'])->name('virtual-meters.search');
Route::get('query', [App\Http\Controllers\VirtualMeterController::class, 'showQueryPage'])->name('virtual-meters.showQuery');
Route::post('query/results', [App\Http\Controllers\VirtualMeterController::class, 'getQueryResults'])->name('virtual-meters.queryResults');
Route::get('virtual-meters/refresh', [App\Http\Controllers\VirtualMeterController::class, 'refresh'])->name('virtual-meters.refresh');
Route::get('virtual-meters/daily-consumption/{virtualMeter}', [App\Http\Controllers\VirtualMeterController::class, 'getMeterDailyConsumption'])->name('virtual-meters.daily-consumption');

Route::get('virtual-meters/load', [App\Http\Controllers\VirtualMeterController::class, 'load'])->name('virtual-meters.load');
Route::get('virtual-meters/generation', [App\Http\Controllers\VirtualMeterController::class, 'generation'])->name('virtual-meters.generation');

Route::get('losses/query', [App\Http\Controllers\VirtualMeterController::class, 'showLossQueryPage'])->name('virtual-meters.showLossQuery');
Route::post('losses', [App\Http\Controllers\VirtualMeterController::class, 'lossCalculation'])->name('virtual-meters.calculate-losses');

// Route::get('variables', [App\Http\Controllers\ConvergeVariableController::class, 'index'])->name('variables.index');

Route::get('customers/currentbill', [CustomerController::class, 'currentbill'])->name('customers.currentbill');
Route::get('customers/statementsheet', [CustomerController::class, 'currentstatementsheet'])->name('customers.currentstatementsheet');
Route::get('customers/coverletter', [CustomerController::class, 'currentcoverletter'])->name('customers.currentcoverletter');

Route::resources([
    'customers'       => CustomerController::class,
    'feeders'         => FeederController::class,
    'meter-locations' => MeterLocationController::class,
    'variables'       => ConvergeVariableController::class,
]);