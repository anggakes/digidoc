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
//
Route::get('/', function () {
    return view('welcome');
});

Route::get('/apps/', function () {
    return view('apps');
});

Auth::routes();

Route::middleware("auth")->group(function (){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('user', \App\Http\Controllers\UsersController::class);
    Route::resource('job_position', \App\Http\Controllers\JobPositionController::class);
    Route::resource('external_recipient', \App\Http\Controllers\ExternalRecipientController::class);
    Route::resource('document_template', \App\Http\Controllers\DocumentTemplateController::class);

    Route::get('document/compose', [\App\Http\Controllers\DocumentController::class, 'compose']);
    Route::get('document/compose/memo', [\App\Http\Controllers\DocumentController::class, 'memo'])->name('document.memo');
    Route::post('document/compose/memo', [\App\Http\Controllers\DocumentController::class, 'memoStore'])->name('document.memo.store');
    Route::get('document/print/memo/{id}', [\App\Http\Controllers\DocumentController::class, 'memoPrint'])->name('document.memo.print');
    Route::get('document/sign/memo/{id}', [\App\Http\Controllers\DocumentController::class, 'memoSign'])->name('document.memo.sign');
    Route::post('document/disposisi/memo/{id}', [\App\Http\Controllers\DocumentController::class, 'memoDisposisi'])->name('document.memo.disposisi');
    Route::get('document/view/memo/{id}', [\App\Http\Controllers\DocumentController::class, 'memoViewed'])->name('document.memo.view');


    Route::get('document/compose/beritaAcara', [\App\Http\Controllers\DocumentController::class, 'beritaAcara'])->name('document.beritaAcara');
    Route::post('document/compose/beritaAcara', [\App\Http\Controllers\DocumentController::class, 'beritaAcaraStore'])->name('document.beritaAcara.store');
    Route::get('document/print/beritaAcara/{id}', [\App\Http\Controllers\DocumentController::class, 'beritaAcaraPrint'])->name('document.beritaAcara.print');
    Route::get('document/sign/beritaAcara/{id}', [\App\Http\Controllers\DocumentController::class, 'beritaAcaraSign'])->name('document.beritaAcara.sign');
    Route::get('document/view/beritaAcara/{id}', [\App\Http\Controllers\DocumentController::class, 'beritaAcaraViewed'])->name('document.beritaAcara.view');


    Route::get('document/compose/suratMasuk', [\App\Http\Controllers\DocumentController::class, 'suratMasuk'])->name('document.suratMasuk');
    Route::post('document/compose/suratMasuk', [\App\Http\Controllers\DocumentController::class, 'suratMasukStore'])->name('document.suratMasuk.store');
    Route::post('document/disposisi/suratMasuk/{id}', [\App\Http\Controllers\DocumentController::class, 'suratMasukDisposisi'])->name('document.suratMasuk.disposisi');
    Route::get('document/view/suratMasuk/{id}', [\App\Http\Controllers\DocumentController::class, 'suratMasukViewed'])->name('document.suratMasuk.view');


    Route::get('document/compose/suratKeluar', [\App\Http\Controllers\DocumentController::class, 'suratKeluar'])->name('document.suratKeluar');
    Route::post('document/compose/suratKeluar', [\App\Http\Controllers\DocumentController::class, 'suratKeluarStore'])->name('document.suratKeluar.store');
    Route::get('document/print/suratKeluar/{id}', [\App\Http\Controllers\DocumentController::class, 'suratKeluarPrint'])->name('document.suratKeluar.print');
    Route::get('document/sign/suratKeluar/{id}', [\App\Http\Controllers\DocumentController::class, 'suratKeluarSign'])->name('document.suratKeluar.sign');
    Route::get('document/menyetujui/suratKeluar/{id}', [\App\Http\Controllers\DocumentController::class, 'suratKeluarMenyetujui'])->name('document.suratKeluar.menyetujui');

    Route::resource('document', \App\Http\Controllers\DocumentController::class);


    Route::get('inbox', [\App\Http\Controllers\DocumentController::class, 'inbox'])->name('document.inbox');
    Route::get('sent', [\App\Http\Controllers\DocumentController::class, 'sent'])->name('document.sent');



    Route::get('document_classification', [\App\Http\Controllers\DocumentClassificationController::class, 'index']);

});
