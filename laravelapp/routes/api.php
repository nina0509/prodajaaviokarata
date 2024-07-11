<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//NEULOGOVANI
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('flights', [FlightController::class, 'index']);
Route::apiResource('seats', SeatController::class);
Route::get('flights/{id}/seats', [SeatController::class, 'getSeatsByFlight']);
Route::post('reservations/{id}/approve', [ReservationController::class, 'approve']);
Route::post('reservations/{id}/reject', [ReservationController::class, 'reject']);

Route::get('reservations', [ReservationController::class, 'index']);
//RUTE ZA BILO KOG ULOGOVANOG (I ADMIN I KORISNIK)
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('user', [AuthController::class, 'user'])->middleware('auth:sanctum');
 

// Rute za admina
Route::middleware(['auth:sanctum'   ])->group(function () {
    Route::apiResource('flights', FlightController::class)->except('index');
    Route::apiResource('reservations', ReservationController::class);
    //samo ulogovani obican korisnik moze da preuzme karte koje je kupio 
    Route::apiResource('tickets', TicketController::class);
    Route::get('tickets/{id}/download-pdf', [TicketController::class, 'downloadPdf']);

    Route::get('statistics', [ReservationController::class, 'statistics']);

});
 