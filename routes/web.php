<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.login');
});

// 🔐 Ruta solo para Administrador
Route::get('/admin', function () {
    return 'Acceso solo para Administrador';
})->middleware('role:Administrador');

// 👤 Ruta solo para Cliente
Route::get('/cliente', function () {
    return 'Acceso solo para Cliente';
})->middleware('role:Cliente');
