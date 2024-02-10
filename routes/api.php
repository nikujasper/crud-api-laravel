<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController; 
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('students', [UsersController::class, 'index']);
Route::post('student', [UsersController::class, 'store']);
Route::get('student/{id}', [UsersController::class, 'show']);
Route::put('student/{id}', [UsersController::class, 'update']);
Route::delete('student/{id}', [UsersController::class, 'destroy']);