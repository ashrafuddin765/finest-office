<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\WinnerController;
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

Route::get( '/', [HomeController::class, 'index'] )->name( 'home' );

// Route::get( '/', 'App\Http\Controllers\OfficeReportController@Index' );
// Route::get( '/{id}/edit', 'App\Http\Controllers\OfficeReportController@edit' )->middleware( 'auth' );
// Route::put( '/{id}/edit', 'App\Http\Controllers\OfficeReportController@update' )->middleware( 'auth' );

// Route::get( '/create-employee/', 'App\Http\Controllers\OfficeReportController@create' )->middleware( 'auth' );
// Route::post( '/create-employee/', 'App\Http\Controllers\OfficeReportController@store' )->middleware( 'auth' );

Route::middleware( 'auth' )->group( function () {
    Route::get( '/dashboard/winner', [WinnerController::class, 'Index'] )->name( 'winner' );
    Route::get( '/dashboard/select-winner', [WinnerController::class, 'create'] )->name( 'select-winner' );

    Route::get( 'old-reports', [LeaderboardController::class, 'oldReports'] )->name( 'old-reports' );

    Route::get( '/dashboard/point-request', [LeaderboardController::class, 'requestForm'] )->name( 'request-form' );

    Route::get( '/dashboard/pending-request', [LeaderboardController::class, 'pendingRequestList'] )->name( 'pending-request' );

    Route::get( '/dashboard/approve-all', [LeaderboardController::class, 'approveAll'] )->name( 'approve-all' );

    Route::resource( 'dashboard', LeaderboardController::class );

    //winner

} );

require __DIR__ . '/auth.php';
