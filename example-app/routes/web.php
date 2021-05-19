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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('docno', \App\Http\Controllers\DocNoController::class);
Route::resource('user', \App\Http\Controllers\UsersController::class);
Route::get('/letter/sent', [App\Http\Controllers\LetterController::class, 'sent']);
Route::get('/letter/draft', [App\Http\Controllers\LetterController::class, 'draft']);
Route::get('/letter/inbox', [App\Http\Controllers\LetterController::class, 'inbox']);

Route::resource('letter', \App\Http\Controllers\LetterController::class);

