<?php

use masoudnabavi\LoginPro\App\Http\Controllers\authentication\addUserController;
use masoudnabavi\LoginPro\App\Http\Controllers\authentication\deleteUserController;
use masoudnabavi\LoginPro\App\Http\Controllers\authentication\editUserController;
use masoudnabavi\LoginPro\App\Http\Controllers\authentication\forgetAndChangePasswordController;
use masoudnabavi\LoginPro\App\Http\Controllers\authentication\listUserController;
use masoudnabavi\LoginPro\App\Http\Controllers\authentication\loginAsSecondUserController;
use masoudnabavi\LoginPro\App\Http\Controllers\authentication\loginUserController;
use masoudnabavi\LoginPro\App\Http\Controllers\authentication\logoutController;
use masoudnabavi\LoginPro\App\Http\Controllers\authentication\logoutSecondUserController;
use masoudnabavi\LoginPro\App\Http\Controllers\authentication\registerUserController;
use masoudnabavi\LoginPro\App\Http\Controllers\authentication\twoStepAuthUserController;
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

//Route::middleware('Auth')->group(function () {
Route::prefix('user')->group(function () {

    Route::get('login', [loginUserController::class, 'index'])->name('loginUserGet');
    Route::post('login', [loginUserController::class, 'login'])->name('loginUserPost');

    Route::get('register', [registerUserController::class, 'index'])->name('registerUserGet');
    Route::post('register', [registerUserController::class, 'register'])->name('registerUserPost');

    Route::get('forgetPassword', [forgetAndChangePasswordController::class, 'indexForget'])->name('forgetPasswordGet');
    Route::post('forgetPassword', [forgetAndChangePasswordController::class, 'forget'])->name('forgetPasswordPost');

    Route::post('2step', [twoStepAuthUserController::class, 'sendCode'])->name('2stepSendCodePost');

    Route::get('2stepCheck', [twoStepAuthUserController::class, 'indexCheck'])->name('2stepCheckGet');
    Route::post('2stepCheck', [twoStepAuthUserController::class, 'check'])->name('2stepCheckPost');
});
//});


Route::middleware('Auth:isLogin')->group(function () {
    Route::prefix('user')->group(function () {

        Route::get('dashboard', function () {
            return 'This Is Dashboard!';
        })->name('dashboard');

        Route::post('login_as_second_user', [loginAsSecondUserController::class, 'saveSecondUserToken'])->name('loginSecondUserPost');

        Route::get('add', [addUserController::class, 'index'])->name('addUserGet');
        Route::post('add', [addUserController::class, 'add'])->name('addUserPost');

        Route::get('{id}/edit', [editUserController::class, 'index'])->name('editUserGet');
        Route::post('edit', [editUserController::class, 'edit'])->name('editUserPost');

        Route::delete('{id}/delete', [deleteUserController::class, 'delete'])->name('deleteUserDelete');

        Route::get('list', [listUserController::class, 'index'])->name('listUserGet');

        Route::get('changePassword', [forgetAndChangePasswordController::class, 'indexChange'])->name('changePasswordGet');
        Route::post('changePassword', [forgetAndChangePasswordController::class, 'change'])->name('changePasswordPost');

        Route::get('logout', [logoutController::class, 'index'])->name('logoutGet');

        Route::get('logout_second', [logoutSecondUserController::class, 'index'])->name('logoutSecondGet');

    });
});
