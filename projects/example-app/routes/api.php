<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FornecedorController;

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
Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// List Fornecedor
Route::get('fornecedor', [FornecedorController::class, 'index']);

// List single fornecedor
Route::get('fornecedor/{id}', [FornecedorController::class, 'show']);

// Create new fornecedor
Route::middleware('auth:sanctum')->post('fornecedor', [FornecedorController::class, 'store']);

// Update fornecedor
Route::middleware('auth:sanctum')->put('fornecedor/{id}', [FornecedorController::class, 'update']);

// Delete fornecedor
Route::middleware('auth:sanctum')->delete('fornecedor/{id}', [FornecedorController::class,'destroy']);



