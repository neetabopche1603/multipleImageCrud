<?php

use App\Http\Controllers\ImageController;
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

Route::controller(ImageController::class)->group(function(){
    Route::get('show-images','index')->name('img.showImages');
    Route::get('add-image','addFormView')->name('img.addFormView');
    Route::post('add-image','imageUpload')->name('img.imageStore');
    Route::get('edit-image/{ids}','imageEdit')->name('img.imageEdit');
    Route::post('edit-image','imageUpdate')->name('img.imageUpdate');
    Route::get('delete-image/{id}','imageDelete')->name('img.imageDelete');
    Route::post('delete-single-image','updateTimeDeleteImg')->name('img.updateTimeDeleteImg');

});
