<?php

use Illuminate\Support\Facades\Route;

/***************************************************

    Routes for intial access for the application

****************************************************/

Route::get('/', function () {
    return view('signin');
})->name('signin');

Route::get('/register', function () {
    return view('registration');
})->name('register');


/***************************************************

    Route for intial entry in to the application

****************************************************/

Route::post('/landing', function () {
    session(['name' => request('name')]);
    $password = request('password');

    return view('landing', [
        'name' => session('name'),
        'password' => $password,
    ]);
})->name('landing');

/***************************************************

    Route for logging out of the application

****************************************************/

Route::get('/logout', function () {
    // Clear all session data
    session()->flush();

    return redirect()->route('signin');
})->name('logout');


/***************************************************

    Routes for the applications's top level menu

****************************************************/

Route::get('/admin', function () {
    return view('menu_top.admin', [
        'name' => session('name')
    ]);
})->name('admin');

Route::get('/customers', function () {
    return view('menu_top.customers', [
        'name' => session('name')
    ]);
})->name('customers');

Route::get('/inventory', function () {
    return view('menu_top.inventory', [
        'name' => session('name')
    ]);
})->name('inventory');

Route::get('/profile', function () {
    return view('menu_top.profile', [
        'name' => session('name')
    ]);
})->name('profile');

Route::get('/sales', function () {
    return view('menu_top.sales', [
        'name' => session('name')
    ]);
})->name('sales');

Route::get('/tasks', function () {
    return view('menu_top.tasks', [
        'name' => session('name')
    ]);
})->name('tasks');

