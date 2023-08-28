<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JayantController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('jayant');
});

Route::get('/index/{file?}', [JayantController::class, 'index'])->name('index');

Route::post('/store', [JayantController::class, 'store'])->name('store');
Route::get('/show', [JayantController::class, 'show'])->name('show');
Route::get('/edit/{id}', [JayantController::class, 'edit'])->name('edit');
Route::put('/update/{id}', [JayantController::class, 'update'])->name('update');
Route::delete('/delete/{id}', [JayantController::class, 'delete'])->name('delete');
Route::post('/upload', [JayantController::class, 'upload'])->name('upload');

