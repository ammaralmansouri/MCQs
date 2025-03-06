<?php

use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Getting Tests and quesetions ..
Route::get('/tests', [TestController::class, 'getAllTests']);
Route::get('/tests/{id}/questions', [TestController::class, 'getQuestions']);

// Add completed test info to database ..
Route::post('/submit-test', [TestController::class, 'submitTest']);

// Get Completed Tests ..
Route::get('/completed-tests', [TestController::class, 'getCompletedTests']);

// Get Test Info to show in Achievements     ..
Route::get('/achievements/{userId}', [TestController::class, 'getCompletedTestsToShowInAchievements']);



