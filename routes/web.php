<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
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
    return view('layouts.master');
});

//to show register form
Route::get('/user-register',[loginController::class,'registForm'])->name('user.register');
// save user to database
Route::post('/user-register',[loginController::class,'saveUser'])->name('add.user');
// show users
Route::get('/users',[loginController::class,'users'])->name('users');
// show update form
Route::get('/user-update/{id}',[loginController::class,'userUpdate']);
// save update
Route::post('/save-update',[loginController::class,'saveUpdate'])->name('save.update');
// delete user
Route::get('/user-delete/{id}',[loginController::class,'userDelete'])->name('user.delete');
// delete all seleted
Route::delete('delete-selected',[loginController::class,'useDeleteAll'])->name('deleteAll');
// show login form
Route::get('/login',[loginController::class,'logIn'])->name('login');
// to login user
Route::post('/user-login',[loginController::class,'uerLogin'])->name('user.login');
// to logout user
Route::get('/logout',[loginController::class,'uerLogout'])->name('user.logout');