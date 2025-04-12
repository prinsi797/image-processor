<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;

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
    return view('images.index');
});



// Route::get('/', function () {
//     return redirect()->route('images.index');
// });

Route::get('/images', [ImageController::class, 'index'])->name('images.index');
Route::post('/images/upload', [ImageController::class, 'upload'])->name('images.upload');
Route::post('/images/{id}/process', [ImageController::class, 'process'])->name('images.process');
Route::get('/images/{id}/download', [ImageController::class, 'download'])->name('images.download');