<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get("/", [\App\Http\Controllers\ContactController::class, "index"])->name("contact.index");
Route::post("/search", [\App\Http\Controllers\ContactController::class, "search"])->name("contact.search");
Route::middleware("auth")->group(function (){
    Route::get("/trashed", [\App\Http\Controllers\ContactController::class, "trashed"])->name('contact.trashed');
    Route::put("/trashed/{id}", [\App\Http\Controllers\ContactController::class, "restore"])->name('contact.trashed.restore');
    Route::post("/trashed/search", [\App\Http\Controllers\ContactController::class, "searchTrashed"])->name("contact.trashed.search");
    Route::post("/", [\App\Http\Controllers\ContactController::class, "store"])->name('contact.store');
    Route::put("/{id}", [\App\Http\Controllers\ContactController::class, "update"])->name('contact.update');
    Route::delete("/{id}", [\App\Http\Controllers\ContactController::class, "destroy"])->name('contact.destroy');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
