<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\ModuleController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\UserController;

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
//Backend Route

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function(){
    //Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    //resource Routes
    Route::resource('/module', ModuleController::class);
    Route::resource('/permission', PermissionController::class);
    Route::resource('/role', RoleController::class);
    Route::resource('/users', UserController::class);
    Route::get('/check/user/is_active', [UserController::class,'checkActive'])->name('user.is_active');
    //Profile Controller
    Route::get('/profile', [ProfileController::class,'index'])->name('user.profile');
    Route::post('/profile', [ProfileController::class,'updateProfile'])->name('user.profile.store');

});
