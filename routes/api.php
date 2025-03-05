<?php

use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/tests', [TestController::class, 'getAllTests']);
Route::get('/tests/{id}/questions', [TestController::class, 'getQuestions']);


Route::post('/submit-test', [TestController::class, 'submitTest']);
Route::get('/completed-tests', [TestController::class, 'getCompletedTests']);

