<?php

use Illuminate\Support\Facades\Route;


/***************************************************

    Resource Routes for the application

****************************************************/

Route::resource('users', UsersController::class);
Route::resource('roles', RolesController::class);
Route::resource('users_roles', UsersRolesController::class);
Route::resource('pot_sizes', PotSizesController::class);
Route::resource('tree_types', TreeTypesController::class);
Route::resource('trees', TreesController::class);
Route::resource('blocks', BlocksController::class);
Route::resource('aisles', AislesController::class);
Route::resource('areas', AreasController::class);
Route::resource('locations', LocationsController::class);
Route::resource('inventories', InventoriesController::class);
Route::resource('prices', PricesController::class);
Route::resource('exception_prices', ExceptionPricesController::class);
Route::resource('tasks', TasksController::class);
Route::resource('allocated_tasks', AllocatedTasksController::class);
Route::resource('allocated_tasks_users', AllocatedTasksUsersController::class);
Route::resource('customers', CustomersController::class);
Route::resource('sales', SalesController::class);
Route::resource('sale_items', SaleItemsController::class);
Route::resource('farm_details', FarmDetailsController::class);


/***************************************************

    Web Routes for intial access for the application

****************************************************/

Route::get('/', function () {
    return view('signin');
})->name('signin');

Route::get('/register', function () {
    return view('registration');
})->name('register');


/***************************************************

    Web Route for intial entry in to the application

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

    Web Route for logging out of the application

****************************************************/

Route::get('/logout', function () {
    // Clear all session data
    session()->flush();

    return redirect()->route('signin');
})->name('logout');


/***************************************************

    Web Routes for the applications's top level menu

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


/***************************************************

    Web Routes for the applications's Admin menu

****************************************************/

Route::get('/admin/details', function () {
    return view('admin.details', [
        'name' => session('name')
    ]);
})->name('admin.details');

Route::get('/admin/locations', function () {
    return view('admin.locations', [
        'name' => session('name')
    ]);
})->name('admin.locations');

Route::get('/admin/pots', function () {
    return view('admin.pots', [
        'name' => session('name')
    ]);
})->name('admin.pots');

Route::get('/admin/prices', function () {
    return view('admin.prices', [
        'name' => session('name')
    ]);
})->name('admin.prices');

Route::get('/admin/tasks', function () {
    return view('admin.tasks', [
        'name' => session('name')
    ]);
})->name('admin.tasks');

Route::get('/admin/trees', function () {
    return view('admin.trees', [
        'name' => session('name')
    ]);
})->name('admin.trees');

Route::get('/admin/users', function () {
    return view('admin.users', [
        'name' => session('name')
    ]);
})->name('admin.users');
