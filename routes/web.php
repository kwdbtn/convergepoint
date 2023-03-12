<?php

use App\Http\Controllers\ConvergeVariableController;
use App\Http\Controllers\CriticalLineController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerReadingController;
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
Route::get('customers/email/{customer}/{virtualMeter}/send-email', [CustomerController::class, 'sendEmail'])->name('customers.send-email');

Route::resources([
    'customers'       => CustomerController::class,
    'feeders'         => FeederController::class,
    'meter-locations' => MeterLocationController::class,
    'variables'       => ConvergeVariableController::class,
    'critical-lines' => CriticalLineController::class,
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('customers/{customer}/query', [App\Http\Controllers\CustomerReadingController::class, 'showQueryPage'])->name('customer-readings.showQuery');
Route::post('customers/{customer}/query/results', [App\Http\Controllers\CustomerReadingController::class, 'getQueryResults'])->name('customer-readings.queryResults');

Route::get('customer-readings/{customer}', [CustomerReadingController::class, 'index'])->name('customer-readings.index');
Route::get('customer-readings/{reading}/{customer}', [CustomerReadingController::class, 'show'])->name('customer-readings.show');
Route::get('customer-readings/{reading}/{customer}/{virtualMeter}/{variable}', [CustomerReadingController::class, 'showMeterReading'])->name('customer-readings.show-meter-readings');
Route::post('customer-readings/approval/{reading}', [CustomerReadingController::class, 'meterApproval'])->name('customer-readings.approval');

Route::get('critical-lines/x/queryall', [App\Http\Controllers\CriticalLineController::class, 'showQueryPageAll'])->name('critical-lines.showQueryAll');
Route::post('critical-lines/query-results-all', [App\Http\Controllers\CriticalLineController::class, 'getQueryResultsAll'])->name('critical-lines.queryResultsAll');

Route::get('critical-lines/{criticalline}/query', [App\Http\Controllers\CriticalLineController::class, 'showQueryPage'])->name('critical-lines.showQuery');
Route::post('critical-lines/query-results', [App\Http\Controllers\CriticalLineController::class, 'getQueryResults'])->name('critical-lines.queryResults');
