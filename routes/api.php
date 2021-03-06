<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserTransactionsController;
use App\Http\Controllers\Api\CategoryTransactionsController;

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

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('transactions', TransactionController::class);
        Route::post('/transactions/{id}/update', [TransactionController::class, 'update']);
        Route::post('/transactions/{id}/destroy', [TransactionController::class, 'destroy']);

        Route::apiResource('categories', CategoryController::class);
        Route::post('/categories/{id}/update', [CategoryController::class, 'update']);
        Route::post('/categories/{id}/destroy', [CategoryController::class, 'destroy']);

        // Category Transactions
        Route::get('/categories/{category}/transactions', [
            CategoryTransactionsController::class,
            'index',
        ])->name('categories.transactions.index');
        Route::post('/categories/{category}/transactions', [
            CategoryTransactionsController::class,
            'store',
        ])->name('categories.transactions.store');

        Route::apiResource('users', UserController::class);
        Route::post('/users/{id}/update', [UserController::class, 'update']);
        Route::post('/users/{id}/destroy', [UserController::class, 'destroy']);
        
        // User Transactions
        Route::get('/users/{user}/transactions', [
            UserTransactionsController::class,
            'index',
        ])->name('users.transactions.index');
        Route::post('/users/{user}/transactions', [
            UserTransactionsController::class,
            'store',
        ])->name('users.transactions.store');
    });
