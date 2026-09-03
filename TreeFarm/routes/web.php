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

    AJAX Controller Routes for the application
    (these are for refreshing tables without 
    reloading the page)
    (Protected by authentication middleware)

****************************************************/

Route::middleware(['auth', 'can.admin-ops'])->group(function () {

    Route::get('pot_sizes/json', [PotSizesController::class, 'list_json'])
            ->name('pot_sizes.json');

});

/***************************************************

    Resource Routes for the application
    (Protected by authentication and authorization 
    middleware)

****************************************************/

Route::middleware('auth')->group(function () {
    
    Route::resource('allocated_tasks', AllocatedTasksController::class);
    Route::resource('allocated_tasks_users', AllocatedTasksUsersController::class);

});

Route::middleware(['auth', 'can.inventory'])->group(function () {

    Route::resource('inventories', InventoriesController::class);

});

Route::middleware(['auth', 'can.sales'])->group(function () {

    Route::resource('customers', CustomersController::class);
    Route::resource('sales', SalesController::class);
    Route::resource('sale_items', SaleItemsController::class);

});

Route::middleware(['auth', 'can.admin'])->group(function () {

    Route::resource('farm_details', FarmDetailsController::class);
    Route::resource('users', UsersController::class);
    Route::resource('roles', RolesController::class);
    Route::resource('users_roles', UsersRolesController::class);
    Route::resource('tasks', TasksController::class);

});

Route::middleware(['auth', 'can.admin-ops'])->group(function () {

    Route::resource('pot_sizes', PotSizesController::class);
    Route::resource('tree_types', TreeTypesController::class);
    Route::resource('trees', TreesController::class);
    Route::resource('blocks', BlocksController::class);
    Route::resource('aisles', AislesController::class);
    Route::resource('areas', AreasController::class);
    Route::resource('locations', LocationsController::class);

});

Route::middleware(['auth', 'can.admin-sales'])->group(function () {

    Route::resource('prices', PricesController::class);
    Route::resource('exception_prices', ExceptionPricesController::class);

});


/***************************************************

    Additional Controller Routes for the application
    (these are not part of the standard 7 resource 
    routes and aren't part of AJAX functionality)
    (Protected by authentication middleware)

****************************************************/

Route::middleware(['auth', 'can.admin'])->group(function () {

    Route::post('farm_details/{id}/logo', [FarmDetailsController::class, 'update_logo'])
            ->name('farm_details.logo');
    

});

Route::middleware(['auth', 'can.admin-ops'])->group(function () {

    Route::get('pot_sizes/{id}/delete', [PotSizesController::class, 'delete_confirm'])
            ->name('pot_sizes.delete_confirm');
    Route::get('tree_types/{id}/delete', [TreeTypesController::class, 'delete_confirm'])
            ->name('tree_types.delete_confirm');
    Route::get('trees/{id}/delete', [TreesController::class, 'delete_confirm'])
            ->name('trees.delete_confirm');

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

Route::middleware('auth')->group(function () {

    Route::get('/profile', function () {
        return view('menu_top.profile');
    })->name('profile');    

    Route::get('/tasks', function () {
        return view('menu_top.tasks');
    })->name('tasks');

});

Route::middleware(['auth', 'can.inventory'])->group(function () {

    Route::get('/inventory', function () {
        return view('menu_top.inventory');
    })->name('inventory');

});

Route::middleware(['auth', 'can.sales'])->group(function () {

    Route::get('/customers', function () {
        return view('menu_top.customers');        
    })->name('customers');

    Route::get('/sales', function () {
        return view('menu_top.sales');
    })->name('sales');

});

Route::middleware(['auth', 'can.admin'])->group(function () {

    Route::get('/admin', function () {
        return view('menu_top.admin');
    })->name('admin');

});

/***************************************************

    Web Routes for the applications's Admin menu
    (Protected by authentication and authorization
    middleware)

****************************************************/
Route::middleware(['auth', 'can.admin'])->group(function () {

    Route::get('/admin/locations', function () {
        return view('admin.locations');
    })->name('admin.locations');

    Route::get('/admin/prices', function () {
        return view('admin.prices');
    })->name('admin.prices');

    Route::get('/admin/tasks', function () {
        return view('admin.tasks');
    })->name('admin.tasks');

    Route::get('/admin/users', function () {
        return view('admin.users');
    })->name('admin.users');

});

