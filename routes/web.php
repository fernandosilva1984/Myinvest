<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\cotacaoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return redirect('/admin'); })->name('login');
//});


// routes/web.php ou routes/api.php


Route::get('/salvar-cotacoes', [cotacaoController::class, 'buscarESalvarCotacoes']);
