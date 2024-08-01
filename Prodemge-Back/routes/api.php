<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\EnderecoController;

Route::get('/pessoas', [PessoaController::class, 'index']);
Route::post('/pessoas', [PessoaController::class, 'store']);
Route::get('/pessoas/{id}', [PessoaController::class, 'show']);
Route::put('/pessoas/{id}', [PessoaController::class, 'update']);
Route::delete('/pessoas/{id}', [PessoaController::class, 'destroy']);
Route::post('/pessoas/{id}/enderecos', [EnderecoController::class, 'addEndereco']);
Route::delete('/pessoas/deleteAll', [PessoaController::class, 'deleteAll']);

Route::get('/endereco/{id}', [EnderecoController::class, 'show']);
Route::put('/endereco/{id}', [EnderecoController::class, 'update']);
Route::delete('/endereco/{id}', [EnderecoController::class, 'destroy']);