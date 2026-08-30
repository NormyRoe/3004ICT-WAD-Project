<?php

use Illuminate\Support\Facades\Route;

/***************************************************

    Add Controllers for the application

****************************************************/

use App\Http\Controllers\UsersController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersRolesController;
use App\Http\Controllers\PotSizesController;
use App\Http\Controllers\TreeTypesController;
use App\Http\Controllers\TreesController;
use App\Http\Controllers\BlocksController;
use App\Http\Controllers\AislesController;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\LocationsController;
use App\Http\Controllers\InventoriesController;
use App\Http\Controllers\PricesController;
use App\Http\Controllers\ExceptionPricesController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\AllocatedTasksController;
use App\Http\Controllers\AllocatedTasksUsersController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SaleItemsController;
use App\Http\Controllers\FarmDetailsController;


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

    Additional Controller Routes for the application
    (these are not part of the standard 7 resource 
    routes and aren't part of AJAX functionality)

****************************************************/
Route::post('farm_details/{id}/logo', [FarmDetailsController::class, 'update_logo'])
        ->name('farm_details.logo');
Route::get('pot_sizes/{id}/delete', [PotSizesController::class, 'delete_confirm'])
        ->name('pot_sizes.delete_confirm');


/***************************************************

    AJAX Controller Routes for the application
    (these are for refreshing tables without 
    reloading the page)

****************************************************/
Route::get('pot_sizes/json', [PotSizesController::class, 'list_json'])
        ->name('pot_sizes.json');


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

Route::get('/admin/locations', function () {
    return view('admin.locations', [
        'name' => session('name')
    ]);
})->name('admin.locations');

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
