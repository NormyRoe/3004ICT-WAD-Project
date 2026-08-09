<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('signin');
})->name('signin');

Route::get('/register', function () {
    return view('registration');
})->name('register');

Route::post('/landing', function () {
    $name = request('name');
    $password = request('password');

    return view('/landing', [
        'name' => $name,
        'password' => $password,
    ]);
})->name('landing');