<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ContactFormController;
use Illuminate\Support\Facades\Route;

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

Route::get('tests/test', [TestController::class,'index']);

// Route::resource('contacts', ContactFormController::class);

// Route::get('contacts',[ContactFormController::class,'index'])->name('contacts.index');
Route::prefix('contacts')
    ->middleware(['auth'])//認証
    ->controller(ContactFormController::class)//コントローラー指定
    ->name('contacts.')//ルート名
    ->group(function(){
        Route::get('/','index')->name('index');//名前付きルート
        Route::get('/create','create')->name('create');//名前付きルート
        Route::post('/','store')->name('store');//名前付きルート
        Route::get('/{id}','show')->name('show');//名前付きルート
        Route::get('/{id}/edit','edit')->name('edit');//名前付きルート
        Route::post('/{id}','update')->name('update');//名前付きルート
        Route::post('/{id}/destroy','destroy')->name('destroy');//名前付きルート
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
