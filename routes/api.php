<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRolePermissionController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function(){
    //Auth
    Route::get('/me', [AuthenticationController::class, 'me']);
    Route::post('/logout', [AuthenticationController::class, 'logout'])
        ->name('logout');

    //Role & Permission routes
    Route::get('/roles', [RoleController::class, 'index']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::post('/roles/{role}/assign-permission', [RoleController::class, 'assignPermission']);
    Route::post('/roles/{role}/revoke-permission', [RoleController::class, 'revokePermission']);

    // Permission routes
    Route::get('/permissions', [PermissionController::class, 'index']);
    Route::post('/permissions', [PermissionController::class, 'store']);

    // User role and permission routes
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
    Route::post('/users/{user}/assign-role', [UserController::class, 'assignRole']);
    Route::post('/users/{user}/remove-role', [UserController::class, 'removeRole']);
    Route::get('/users/{user}/roles', [UserController::class, 'getRoles']);

    //Products routes
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);
    Route::get('/products', [ProductController::class, 'index']);

    //Employees routes
    Route::post('/employees', [EmployeeController::class, 'store']);
    Route::put('/employees/{employee}', [EmployeeController::class, 'update']);
    Route::get('/employees/{employee}', [EmployeeController::class, 'show']);
    Route::get('/employees', [EmployeeController::class, 'index']);

    //Team routes
    Route::post('/centers', [TeamController::class, 'store']);
    Route::put('/centers/{center}', [TeamController::class, 'update']);
    Route::delete('/centers/{center}', [TeamController::class, 'destroy']);
    Route::get('/centers', [TeamController::class, 'index']);
    Route::get('/centers/options', [TeamController::class, 'getTeamOptions']);

});


Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/auth-otp', [AuthenticationController::class, 'loginWithOtp']);
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/gen-otp', [AuthenticationController::class, 'generate']);
