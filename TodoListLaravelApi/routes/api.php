<?php

use App\Http\Controllers\Api\Doings\DoingController;
use App\Http\Controllers\Api\Types\TypeController;
use App\Http\Controllers\Api\Users\AuthController;
use App\Http\Controllers\Api\Users\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/auth/register', [AuthController::class, 'register']); // Регистрация пользователя
Route::post('/auth/login', [AuthController::class, 'login']); // Проверка данных для фхода и создания токена для доступа к данным пользователя
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum'); // Удаления персонального  токена для доступа к данным

Route::get('/users/getUserData', [UserController::class, 'getUserData']);
Route::patch('/users/updateUserData', [UserController::class, 'updateUserData'])->middleware('auth:sanctum');
Route::delete('/users/deleteUserData', [UserController::class, 'deleteUserData'])->middleware('auth:sanctum');

Route::get('/types/getAllTypes', [TypeController::class], 'getAllTypes');
Route::get('/types/getType', [TypeController::class], 'getType');
Route::patch('/types/updateType', [TypeController::class], 'updateType')->middleware('auth:sanctum');
Route::post('/types/createType', [TypeController::class], 'createType')->middleware('auth:sanctum');
Route::delete('/types/deleteType', [TypeController::class], 'deleteType')->middleware('auth:sanctum');

Route::get('/doings/getAllDoings', [DoingController::class], 'getAllDoings')->middleware('auth:sanctum');
Route::get('/doings/getDoing', [DoingController::class], 'getDoing')->middleware('auth:sanctum');
Route::post('/doings/createDoing', [DoingController::class], 'createDoing')->middleware('auth:sanctum');
Route::patch('/doings/updateDoing', [DoingController::class], 'updateType')->middleware('auth:sanctum');
Route::patch('/doings/setDoneStateToDoing', [DoingController::class], 'setDoneStateToDoing')->middleware('auth:sanctum');
Route::delete('/doings/deleteDoing', [DoingController::class], 'deleteType')->middleware('auth:sanctum');