<?php

use App\Http\Controllers\Backend\BackupController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\ModuleController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SettingController;
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

    Route::resource('/backup', BackupController::class)->only(['index','store','destroy']);
    Route::get('/backup/download/{file_name}',[BackupController::class,'download'])->name('backup.download');
    //Profile Controller
    Route::get('/update-profile', [ProfileController::class,'index'])->name('user.profile');
    Route::post('/update-profile', [ProfileController::class,'updateProfile'])->name('user.profile.store');
    Route::get('/update-password', [ProfileController::class,'password'])->name('user.password');
    Route::post('/update-password', [ProfileController::class,'updatePassword'])->name('user.password.reset');
    //system setting
    Route::group(['as'=>'settings.','prefix'=>'settings'],function(){
        Route::get('general',[SettingController::class,'general'])->name('general');
        Route::post('general',[SettingController::class,'generalUpdate'])->name('general.update');
        //social Media
        Route::get('socialMedia',[SettingController::class,'socialMedia'])->name('socialMedia');
        Route::post('socialMedia',[SettingController::class,'socialMediaUpdate'])->name('socialMedia.update');
         //Mail setting
        Route::get('mail',[SettingController::class,'mailView'])->name('mail');
        Route::post('mail',[SettingController::class,'mailUpdate'])->name('mail.update');
    });

});
