<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaderboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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
    Route::get( 'old-reports', [LeaderboardController::class, 'oldReports'] )->name( 'old-reports' );
    // Route::get('generate-pdf', [LeaderboardController::class, 'generatePDF']);
    Route::get( '/dashboard/point-request', [LeaderboardController::class, 'requestForm'] )->name( 'request-form' );
    
    // dd(Auth());
    
    Route::get( '/dashboard/pending-request', [LeaderboardController::class, 'pendingRequestList'] )->name( 'pending-request' );

    Route::get( '/dashboard/approve-all', [LeaderboardController::class, 'approveAll'] )->name( 'approve-all' );


    Route::resource( 'dashboard', LeaderboardController::class );

} );

require __DIR__ . '/auth.php';
