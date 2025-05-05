<?php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::resource(
    '/user',
    UserController::class
);
Route::post('/user/login', [UserController::class, 'login']);

// Project Resource
Route::resource('/project', ProjectController::class)->middleware('auth:sanctum');
Route::post('/project/join/{project}',[ProjectController::class,'join'])->middleware('auth:sanctum');

// Task Resource
Route::resource('/task',TaskController::class)->middleware('auth:sanctum');
Route::get('/task/{id}/project/{project}',[TaskController::class,'showtask'])->middleware('auth:sanctum');

