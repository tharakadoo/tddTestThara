<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\WebsitePost\IO\Http\WebsiteController;
use App\WebsitePost\IO\Http\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('websites/users', [WebsiteController::class, 'attachUsers']);
Route::get('/websites', [WebsiteController::class, 'index']);
Route::get('/users', [UserController::class, 'index']);

// Route::post('/websites/users', function () {
//     return response()->json(['debug' => 'API route hit']);
// });
