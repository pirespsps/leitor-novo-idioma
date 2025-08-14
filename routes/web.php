<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeitorController;
use App\Http\Controllers\LeitorFormController;
use App\Http\Controllers\BibliotecaController;
use App\Http\Controllers\PalavraController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PraticaController;


Route::get('/', [IndexController::class,'index']);
Route::get('/leitor',[IndexController::class,'index']);

Route::get('/form',[LeitorFormController::class,'index']);
Route::post('/documento/criar',[LeitorFormController::class,'createDocument'])->name("criar-documento");

Route::get("/biblioteca",[BibliotecaController::class,'index']);
Route::post("/biblioteca/remover",[BibliotecaController::class,'remover']);

Route::get('/documento/ler/{id}',[LeitorController::class,'primeiraLeitura']);
Route::post('/documento/ler',[LeitorController::class,'lerAxios'])->name("lerAxios");
Route::post('/documento/salvarPagina',[LeitorController::class,'salvarPagina']);

Route::post('/documento/salvarPalavra',[PalavraController::class, 'salvarPalavra'])->name("salvar-palavra");

Route::get('/palavras',[PalavraController::class,'index']);
Route::get('/palavras/{idioma}',[PalavraController::class,'lerIdioma']);
Route::get('/palavras/{idioma}/praticar',[PraticaController::class,'index']);