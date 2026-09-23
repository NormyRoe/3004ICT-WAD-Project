<?php

use Illuminate\Support\Facades\Route;

/***************************************************

    Profile Controller added to the application by Breeze

****************************************************/
use App\Http\Controllers\ProfileController;


/***************************************************

    Controllers for the application

****************************************************/

use App\Http\Controllers\UsersController;
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
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\FarmDetailsController;
use App\Http\Controllers\UserProfileController;


/***************************************************

    Resource Routes for the application
    (Protected by authentication and authorization 
    middleware)

****************************************************/

Route::middleware('auth')->group(function () {
    
    Route::resource('allocated_tasks', AllocatedTasksController::class);
    Route::get('inventories', [InventoriesController::class, 'index'])->name('inventories.index');
    Route::get('inventories/{id}', [InventoriesController::class, 'show'])->whereNumber('id')->name('inventories.show');

});

Route::middleware(['auth', 'can.inventory'])->group(function () {

    Route::get('inventories/create', [InventoriesController::class, 'create'])->name('inventories.create');
    Route::post('inventories', [InventoriesController::class, 'store'])->name('inventories.store');
    Route::get('inventories/{id}/edit', [InventoriesController::class, 'edit'])->name('inventories.edit');
    Route::put('inventories/{id}', [InventoriesController::class, 'update'])->name('inventories.update');
    Route::delete('inventories/{id}', [InventoriesController::class, 'destroy'])->name('inventories.destroy');

});

Route::middleware(['auth', 'can.sales'])->group(function () {

    Route::resource('customers', CustomersController::class);
    Route::resource('sales', SalesController::class);

});

Route::middleware(['auth', 'can.admin'])->group(function () {

    Route::resource('farm_details', FarmDetailsController::class);
    Route::resource('users', UsersController::class);    

});

Route::middleware(['auth', 'can.admin-ops'])->group(function () {

    Route::resource('pot_sizes', PotSizesController::class);
    Route::resource('tree_types', TreeTypesController::class);
    Route::resource('trees', TreesController::class);
    Route::resource('blocks', BlocksController::class);
    Route::resource('aisles', AislesController::class);
    Route::resource('areas', AreasController::class);
    Route::resource('locations', LocationsController::class);
    Route::resource('tasks', TasksController::class);

});

Route::middleware(['auth', 'can.admin-sales'])->group(function () {

    Route::resource('prices', PricesController::class);
    Route::resource('exception_prices', ExceptionPricesController::class);

});


/***************************************************

    Additional Controller Routes for the application
    (these are not part of the standard 7 resource 
    routes)
    (Protected by authentication middleware)

****************************************************/

Route::middleware('auth')->group(function () {

    Route::get('user_profile/{id}', [UserProfileController::class, 'show'])
            ->name('user_profile.show');
    Route::post('user_profile/{id}', [UserProfileController::class, 'update'])
            ->name('user_profile.update');
    Route::get('allocated_tasks/report/create', [AllocatedTasksController::class, 'create_report'])
            ->name('allocated_tasks.create_report');
    Route::post('allocated_tasks/report/store', [AllocatedTasksController::class, 'store_report'])
            ->name('allocated_tasks.store_report');

});

Route::middleware(['auth', 'can.admin'])->group(function () {

    Route::post('farm_details/{id}/logo', [FarmDetailsController::class, 'update_logo'])
            ->name('farm_details.logo');
    Route::post('users/{id}/approve', [UsersController::class, 'approve'])
            ->name('users.approve');
    Route::get('users/{id}/reject', [UsersController::class, 'reject'])
            ->name('users.reject');
    Route::get('users/{id}/deactivate', [UsersController::class, 'deactivate'])
            ->name('users.deactivate');
    Route::get('users/{id}/reactivate', [UsersController::class, 'reactivate'])
            ->name('users.reactivate');
    Route::get('users/{id}/approval', [UsersController::class, 'approval'])
            ->name('users.approval');
    Route::get('allocated_tasks/{id}/delete', [AllocatedTasksController::class, 'delete_confirm'])
            ->name('allocated_tasks.delete_confirm');

});

Route::middleware(['auth', 'can.admin-ops'])->group(function () {

    Route::get('pot_sizes/{id}/delete', [PotSizesController::class, 'delete_confirm'])
            ->name('pot_sizes.delete_confirm');
    Route::get('tree_types/{id}/delete', [TreeTypesController::class, 'delete_confirm'])
            ->name('tree_types.delete_confirm');
    Route::get('trees/{id}/delete', [TreesController::class, 'delete_confirm'])
            ->name('trees.delete_confirm');
    Route::get('locations/{id}/delete', [LocationsController::class, 'delete_confirm'])
            ->name('locations.delete_confirm');
    Route::get('areas/{id}/delete', [AreasController::class, 'delete_confirm'])
            ->name('areas.delete_confirm');
    Route::get('blocks/{id}/delete', [BlocksController::class, 'delete_confirm'])
            ->name('blocks.delete_confirm');
    Route::get('aisles/{id}/delete', [AislesController::class, 'delete_confirm'])
            ->name('aisles.delete_confirm');
    Route::get('tasks/{id}/delete', [TasksController::class, 'delete_confirm'])
            ->name('tasks.delete_confirm');    

});

Route::middleware(['auth', 'can.admin-sales'])->group(function () {

    Route::get('prices/{id}/delete', [PricesController::class, 'delete_confirm'])
            ->name('prices.delete_confirm');
    Route::get('exception_prices/{id}/delete', [ExceptionPricesController::class, 'delete_confirm'])
            ->name('exception_prices.delete_confirm');

});

Route::middleware(['auth', 'can.sales'])->group(function () {

    Route::get('customers/{id}/sales', [CustomersController::class, 'sales_history'])
            ->name('customers.sales');
    Route::post('/sales/calc-kms', [SalesController::class, 'calcKms'])
            ->name('sales.calcKms');

});

Route::middleware(['auth', 'can.inventory'])->group(function () {

    Route::get('inventories/{id}/delete', [InventoriesController::class, 'delete_confirm'])
            ->name('inventories.delete_confirm');

});


/***************************************************

    Routes added by Breeze to the application

****************************************************/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


/***************************************************

    Forgot Password Route

****************************************************/
Route::get('forgot-password', function () {
    return view('password_reset');
})->middleware('guest')->name('password.forgot');


/***************************************************

    Web Routes for intial access for the application

****************************************************/

Route::get('/', function () {
    return view('signin');
})->name('signin');

Route::get('/login', function () {
    return view('signin');
})->name('login');

Route::get('/register', function () {
    return view('registration');
})->name('register');


/***************************************************

    Web Route for intial entry in to the application

****************************************************/

Route::get('/landing', function () {    
    return view('landing');
})->middleware('auth')->name('landing');


/***************************************************

    Web Routes for the applications's top level menu
    (Protected by authentication and authorization
    middleware)

****************************************************/

Route::middleware(['auth', 'can.admin'])->group(function () {

    Route::get('/admin', function () {
        return view('menu_top.admin');
    })->name('admin');

});

