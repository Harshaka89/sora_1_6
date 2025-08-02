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

// Public Home (Landing or Welcome) page
Route::get('/', function () {
    return view('welcome');
});

// Authenticated Dashboard and Admin Sections
Route::middleware(['auth', 'verified'])->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Reservations List Page (Admin)
    Route::get('/reservations', function () {
        return view('admin.reservations.index');
    })->name('reservations.index');

    // Form to Create a New Reservation (Admin Only)
    Route::get('/reservations/create', function () {
        return view('admin.reservations.create');
    })->name('reservations.create');

    // (Optional) Store reservation, edit, update, delete routes go here
    // Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    // Route::get('/reservations/{id}/edit', ...);
    // Route::put('/reservations/{id}', ...);
    // Route::delete('/reservations/{id}', ...);

    // Place other admin-only routes below
});

// (Optional) Public reservation booking form route, visible to customers
// Route::get('/book', function () {
//     return view('reservation.book');
// })->name('reservation.book');

// Auth scaffolding (login, registration, etc.)
require __DIR__.'/auth.php';
