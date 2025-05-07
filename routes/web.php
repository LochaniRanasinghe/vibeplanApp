<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Customers\CustomerDashboardController;
use App\Http\Controllers\EventOrganizer\EventOrganizerDashboardController;
use App\Http\Controllers\InventoryStaff\InventoryStaffDashboardController;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware('auth')->group(function () {

    //Auth::routes(); 

    // Admin Portal
    Route::group(['prefix' => 'admin', 'middleware' => ['role:admin', 'log_request'], 'as' => 'admin.'], function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('/users', UserController::class);
    });

    // Customer Portal
    Route::group(['prefix' => 'customer', 'middleware' => ['role:customer'], 'as' => 'customer.'], function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
    });

    // Event Organizer Portal
    Route::group(['prefix' => 'event-organizer', 'middleware' => ['role:event_organizer'], 'as' => 'event_organizer.'], function () {
        Route::get('/dashboard', [EventOrganizerDashboardController::class, 'index'])->name('dashboard');
    });

    // Inventory Staff Portal
    Route::group(['prefix' => 'inventory-staff', 'middleware' => ['role:inventory_staff'], 'as' => 'inventory_staff.'], function () {
        Route::get('/dashboard', [InventoryStaffDashboardController::class, 'index'])->name('dashboard');
    });
});


Route::get('/login', [UserController::class, 'login'])->name('login');
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/registeruser', [UserController::class, 'registeruser'])->name('registeruser');
Route::post('/loginuser', [UserController::class, 'loginuser'])->name('loginuser');
Route::get('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');
