<?php

use App\Http\Controllers\v1\AccountController;
use App\Http\Controllers\v1\Auth\AuthController;
use App\Http\Controllers\v1\Auth\PasswordController;
use App\Http\Controllers\v1\Auth\UserController;
use App\Http\Controllers\v1\AuthorizeRequestController;
use App\Http\Controllers\v1\TransactionController;
use Illuminate\Support\Facades\Route;

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

// Api Version
Route::group(['prefix' => 'v1'], function () use ($router) {});
