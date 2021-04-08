<?php

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
/*
Route::get('/', function () {
    return view('welcome');
});
*/

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('');

use App\Http\Controllers\AnimalController;

use App\Http\Controllers\UserRequestController;

use App\Http\Controllers\AdoptedAnimalController;

use App\Http\Controllers\DeniedRequestController;

Route::resource('animals', AnimalController::class);

Route::resource('user_requests', UserRequestController::class);

Route::resource('adopted_animals', AdoptedAnimalController::class);

Route::resource('denied_requests', DeniedRequestController::class);

Route::get('sortBy', [App\Http\Controllers\AnimalController::class, 'sortBy'])->name('sortBy');
