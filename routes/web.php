<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;

// Route View
Route::get('/', [ProdutoController::class, 'index']);

// Route create
Route::post('/cadastro_prod', [ProdutoController::class, 'store']);

// Route Delete
Route::delete('/produto/{id}', [ProdutoController::class, 'destroy']);