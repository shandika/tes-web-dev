<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\YajraController;

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

Route::get('/', [ProgramController::class, 'index'])->name('data');
Route::post('data.views', [ProgramController::class, 'views'])->name('views');
Route::post('data.store', [ProgramController::class, 'store'])->name('data.store');
Route::post('data.edits', [ProgramController::class, 'edits'])->name('edits');
Route::post('data.updates', [ProgramController::class, 'updates'])->name('updates');
Route::post('data.hapus', [ProgramController::class, 'hapus'])->name('hapus');
Route::get('data.cari', [ProgramController::class, 'cari'])->name('cari');
