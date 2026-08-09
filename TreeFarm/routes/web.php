<?php

use Illuminate\Support\Facades\Route;

// Force https routing
URL::forceScheme('https');

// Force correct base path
URL::forceRootUrl('https://s5426172-80.elf.ict.griffith.edu.au/webAppDev-Project/TreeFarm/public');

Route::get('/', function () {
    return view('signin');
})->name('signin');

