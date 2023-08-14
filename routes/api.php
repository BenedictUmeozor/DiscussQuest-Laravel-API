<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::patch('/user', [UserController::class, 'update']);
    Route::get('/users', [UserController::class, 'show']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/questions', [QuestionController::class, 'store']);
    Route::post('/answers', [AnswerController::class, 'store']);
    Route::patch('/answers/{id}', [AnswerController::class, 'update']);
    Route::delete('/questions/{id}', [QuestionController::class, 'destroy']);
    Route::delete('/answers/{id}', [AnswerController::class, 'destroy']);
});

Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/questions', [QuestionController::class, 'index']);
Route::get("/questions/all", [QuestionController::class, 'all']);
Route::get('/questions/{id}', [QuestionController::class, 'show']);
Route::get('answers', [AnswerController::class, 'index']);
Route::get('/profile/{id}', [UserController::class, 'getUser']);
