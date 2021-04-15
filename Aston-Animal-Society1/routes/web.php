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

Route::get('/home', [App\Http\Controllers\AnimalController::class, 'index'])->name('');

use App\Http\Controllers\AnimalController;

use App\Http\Controllers\AdoptionRequestController;

Route::resource('animals', AnimalController::class);

Route::resource('adoption_requests', AdoptionRequestController::class);

Route::get('sortBy', [App\Http\Controllers\AnimalController::class, 'sortBy'])->name('sortBy');

Route::get('sortAndFilterRequests', [App\Http\Controllers\AdoptionRequestController::class, 'sortBy'])->name('sortAndFilterRequests');

Route::get('adopted_animals', [App\Http\Controllers\AnimalController::class, 'adoptedAnimals'])->name('adopted_animals');

Route::get('denied_requests', [App\Http\Controllers\AdoptionRequestController::class, 'deniedRequests'])->name('denied_requests');

Route::get('my_adoption_requests', [App\Http\Controllers\AdoptionRequestController::class, 'myAdoptionRequests'])->name('my_adoption_requests');
