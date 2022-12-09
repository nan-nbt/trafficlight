<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Content\CollectionController;
use App\Http\Controllers\Content\DefectController;
use App\Http\Controllers\Content\LogController;
use App\Http\Controllers\Content\ProcessController;
use App\Http\Controllers\Content\SectionController;
use App\Http\Controllers\Content\SuggestController;

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
    return view('welcome');
});

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/content/collection', [CollectionController::class, 'index'])->name('collection');
Route::get('/content/defect', [DefectController::class, 'index'])->name('defect');
Route::get('/content/log', [LogController::class, 'index'])->name('log');
Route::post('/content/log/login', [LogController::class, 'login'])->name('log.login');
Route::post('/content/log/directlogin', [LogController::class, 'directLogin'])->name('log.directlogin');
Route::get('/content/process', [ProcessController::class, 'index'])->name('process');
Route::get('/content/section', [SectionController::class, 'index'])->name('section');
Route::get('/content/suggest', [SuggestController::class, 'index'])->name('suggest');

