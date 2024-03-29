<?php

use Illuminate\Support\Facades\Route;

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
    return view('auth/login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/pedidos', function () {
        return view('pedidos');
    })->name('pedidos');


    Route::get('/cargas', function () {
        return view('cargas');
    })->name('cargas');


    Route::get('/clientes', function () {
        return view('clientes');
    })->name('clientes');


    Route::get('/custos', function () {
        return view('custos');
    })->name('custos');

    Route::get('/controle', function () {
        return view('page-controle');
    })->name('controle');

});
