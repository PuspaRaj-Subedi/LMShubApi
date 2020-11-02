<?php

use Illuminate\Http\Request;
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


Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);
    Route::post('register', [App\Http\Controllers\AuthController::class, 'register']);
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', [App\Http\Controllers\AuthController::class, 'logout']);
        Route::get('user', [App\Http\Controllers\AuthController::class, 'user']);
    });

    Route::group(['prefix' => 'libarian', 'middleware' => 'auth:api'], function () {
        Route::get('requested', [App\Http\Controllers\BookController::class, 'requested']);
        Route::post('pending/{status}/{user_id}/{book}', [App\Http\Controllers\BookController::class, 'Pending']);
        Route::delete('delete_books/{id}', [App\Http\Controllers\BookController::class, 'destroy']);
        Route::put('update_books/{id}', [App\Http\Controllers\BookController::class, 'update']);
        Route::post('add_books', [App\Http\Controllers\BookController::class, 'create']);
        Route::post('books', [App\Http\Controllers\BookController::class, 'getBooks']);
        Route::post('sendsms', [App\Http\Controllers\BookController::class, 'sendSms']);
        Route::get('books/details/{id}', [App\Http\Controllers\BookController::class, 'getSingle']);
    });

    Route::group(['prefix' => 'student', 'middleware' => 'auth:api'], function () {
        Route::get('myborrow', [App\Http\Controllers\BorrowController::class, 'myBorrow']);
        Route::post('borrows/{id}', [App\Http\Controllers\BorrowController::class, 'store']);
        Route::get('books', [App\Http\Controllers\BookController::class, 'getBooks']);
        Route::get('books/{id}', [App\Http\Controllers\BookController::class, 'getSingle']);
    });
});
