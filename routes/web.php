<?php

use Illuminate\Support\Facades\Route;


Route::redirect('/', '/admin');

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/prueba', function () {
    
    $schedule = \App\Models\Schedule::find(1);

    return $schedule->start_time->format('H:i:s');

})->name('prueba');
