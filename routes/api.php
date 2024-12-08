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
    Route::get('/auth/me', [AuthenticationController::class, 'me']);
    Route::post('/auth/logout', [AuthenticationController::class, 'logout'])
        ->name('logout');

    //Role & Permission routes
    Route::get('/roles/options', [RoleController::class, 'getRoleOptions']);
    Route::get('/roles/{role}', [RoleController::class, 'getDetail']);
    Route::put('/roles/{role}', [RoleController::class, 'update']);
    Route::post('/roles/{role}/assign-permission', [RoleController::class, 'assignPermission']);
    Route::post('/roles/{role}/revoke-permission', [RoleController::class, 'revokePermission']);


    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
    Route::post('/users/{user}/assign-role', [UserController::class, 'assignRole']);
    Route::post('/users/{user}/remove-role', [UserController::class, 'removeRole']);
    Route::get('/users/{user}/roles', [UserController::class, 'getRoles']);

    //Products routes
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);
    Route::get('/products', [ProductController::class, 'index']);

    //Employees routes
    Route::put('/employees/{employee}', [EmployeeController::class, 'update']);
    Route::get('/employees/{employee}', [EmployeeController::class, 'show']);

    //Team routes
    Route::delete('/teams/{center}', [TeamController::class, 'destroy']);
    Route::get('/teams', [TeamController::class, 'index']);
    Route::get('/teams/options', [TeamController::class, 'getTeamOptions']);

    Route::get('/{module}', [\App\Http\Controllers\ModuleController::class, 'index']);
    Route::get('/{module}/{id}', [\App\Http\Controllers\ModuleController::class, 'show']);
    Route::post('/{module}', [\App\Http\Controllers\ModuleController::class, 'save']);
    Route::put('/{module}', [\App\Http\Controllers\ModuleController::class, 'save']);

});


Route::post('/auth/login', [AuthenticationController::class, 'login']);
Route::post('/auth/auth-otp', [AuthenticationController::class, 'loginWithOtp']);
Route::post('/auth/register', [AuthenticationController::class, 'register']);
Route::post('/auth/gen-otp', [AuthenticationController::class, 'generate']);
