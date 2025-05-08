<?php

use App\Http\Controllers\RekapPascaDaftungController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('home');
// });
Route::get('/get-targets/{unit}', [RekapPascaDaftungController::class, 'getTargets']);
Route::get('/get-rekap-data/{unit}', [RekapPascaDaftungController::class, 'getRekapData']);

Route::controller(RekapPascaDaftungController::class)->group(function () {
    Route::get('/', 'index')->name('rekap-pascadaftung.index');
    Route::get('/administrator', 'administrator')->name('rekap-pascadaftung.administrator');
    Route::post('/rekap-pascadaftung/store', 'store')->name('rekap-pascadaftung.store');
    // Route::get('/rekap-pascadaftung/{id}', 'show')->name('rekap-pascadaftung.show');
    Route::put('/rekap-pascadaftung/{id}', 'edit')->name('rekap-pascadaftung.edit');
    Route::put('/rekap-pascadaftung', 'update')->name('rekap-pascadaftung.update');
    Route::delete('/rekap-pascadaftung/{id}', 'destroy')->name('rekap-pascadaftung.destroy');
});
