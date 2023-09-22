<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserApiController;
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
Route::get('/daftar', [UserApiController::class, 'daftar']);
Route::get('/tabung', [UserApiController::class, 'tabung']);
Route::get('/tarik', [UserApiController::class, 'tarik']);
Route::get('/saldo/{row1}', [UserApiController::class, 'saldo']);
Route::get('/mutasi/{row1}', [UserApiController::class, 'mutasi']);
Route::get('/daftar_json_file', [UserApiController::class, 'daftar_json_file']);