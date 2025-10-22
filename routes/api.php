<?php

use App\Http\Controllers\Api\AbsenceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('absences', [App\Http\Controllers\Api\AbsenceController::class,'index'])->middleware('auth:sanctum');
Route::post('absences', [App\Http\Controllers\Api\AbsenceController::class,'store'])->middleware('auth:sanctum');
Route::delete('absences/{id}', [App\Http\Controllers\Api\AbsenceController::class,'destroy'])->middleware('auth:sanctum');
Route::get('absences/{id}', [AbsenceController::class, 'show'])->middleware('auth:sanctum');
Route::put('absences/{id}', [AbsenceController::class, 'update'])->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
