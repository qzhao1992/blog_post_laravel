<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PostsController;

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

Route::get('/', [HomeController::class, 'home'])->middleware(['auth'])
    ->name('home.index');
Route::get('/contact', [HomeController::class, 'contact'])->middleware(['auth'])
    ->name('home.contact');

    Route::get('/home', [HomeController::class, 'home'])->middleware(['auth'])
    ->name('home.index');
// Route::get('/single', AboutController::class);

Route::resource('posts', PostsController::class)->middleware(['auth']);

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
