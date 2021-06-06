# LoginPro
[![Issues](https://img.shields.io/github/issues/masoudnabavi/login_pro?label=Issues)](https://img.shields.io/github/issues/masoudnabavi/login_pro)
[![Stars](https://img.shields.io/github/stars/masoudnabavi/login_pro)](https://img.shields.io/github/stars/masoudnabavi/login_pro)

This is a library for logging in and authenticating in the system, which has features such as: login with password and without password, login with username, mobile, code, email, working with this library is very easy.

## Install
```bash
composer require masoudnabavi/login_pro
```

## Add to .env file
```
usePassword=0  //0 means you Dont Want To Use Password And 1 means You Want To Use Password
useCookie=0    // 0 means use Session And 1 means Use Cookie
sentCodeLimitNumber=3  //The number of times a user can receive a 2Step Code before their account is blocked
```

## Add User Params And Validation
```
    'mobile' => 'sometimes|iran_mobile|unique:users',
    'email' => 'sometimes|email|unique:users',
    'username' => 'sometimes|string|min:3|max:100|unique:users',
    'national_code' => 'sometimes|melli_code|unique:users',
    'password' => 'sometimes|string|min:6|max:200'
```

## Edit User Params And Validation
```
   'id' => 'sometimes|exists:users',
   'mobile' => 'sometimes|iran_mobile',
   'email' => 'sometimes|email',
   'username' => 'sometimes|string|min:3|max:100',
   'national_code' => 'sometimes|melli_code',
   'password' => 'sometimes|string|min:6|max:200'
```

## Delete User Params And Validation
```
    'id' => 'required|exists:users'
```

## Login User Params And Validation

```
    'mobile' => 'sometimes|iran_mobile',
    'email' => 'sometimes|email',
    'username' => 'sometimes|string|min:3|max:100',
    'national_code' => 'sometimes|melli_code',
    'password' => 'sometimes|string|min:6|max:200'
```

## Login As Second User

```
    To Login As Second User Just Need To send Second Usser`s user_id 
```

## Routes

```

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

Route::middleware('authentications:isLogin')->group(function () {
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

```
## Get Login User`s Data
Every Where You Need User`s Data Just Paste This Code :
```
  getLoginUserDataController::getLoginUserData();
```
