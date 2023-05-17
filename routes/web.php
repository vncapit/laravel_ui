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
    return view('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/menu/get', [App\Http\Controllers\Menu\MenuController::class, 'getMenu'])->name('menu.get');
Route::post('/menu/delete', [App\Http\Controllers\Menu\MenuController::class, 'deleteMenu'])->name('menu.delete');
Route::post('/menu/edit', [App\Http\Controllers\Menu\MenuController::class, 'editMenu'])->name('menu.edit');
Route::post('/menu/add', [App\Http\Controllers\Menu\MenuController::class, 'addMenu'])->name('menu.add');
