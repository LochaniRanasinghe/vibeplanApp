<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\EventTypeController;
use App\Http\Controllers\Admin\CustomEventController;
use App\Http\Controllers\Admin\EventRequestController;
use App\Http\Controllers\Admin\InventoryItemController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\EventInventoryOrderController;
use App\Http\Controllers\Customers\CustomerDashboardController;
use App\Http\Controllers\EventOrganizer\EventOrganizerDashboardController;
use App\Http\Controllers\EventOrganizer\EventTypeController as EventOrganizerEventTypeController;
use App\Http\Controllers\EventOrganizer\EventRequestController as EventOrganizerEventRequestController;
use App\Http\Controllers\EventOrganizer\CustomEventController as EventOrganizerCustomEventController;
use App\Http\Controllers\EventOrganizer\InventoryItemController as EventOrganizerInventoryItemController;
use App\Http\Controllers\EventOrganizer\EventInventoryOrderController as EventOrganizerEventInventoryOrderController;
use App\Http\Controllers\EventOrganizer\PaymentController as EventOrganizerPaymentController;
use App\Http\Controllers\InventoryStaff\InventoryStaffDashboardController;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware('auth')->group(function () {

    //Auth::routes(); 

    // Admin Portal
    Route::group(['prefix' => 'admin', 'middleware' => ['role:admin', 'log_request'], 'as' => 'admin.'], function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        Route::get('users/get-event-organizers', [UserController::class, 'getEventOrganizers'])->name('users.get-event-organizers');
        Route::get('users/get-inventory-staff', [UserController::class, 'getInventoryStaff'])->name('users.get-inventory-staff');
        Route::get('users/get-customers', [UserController::class, 'getCustomers'])->name('users.get-customers');
        Route::resource('users', UserController::class);

        Route::get('event-types/get-event-types', [EventTypeController::class, 'getEventTypes'])->name('event-types.get-event-types');
        Route::resource('event-types', EventTypeController::class);

        Route::get('event-requests/get-event-requests', [EventRequestController::class, 'getEventRequests'])->name('event-requests.get-event-requests');
        Route::resource('event-requests', EventRequestController::class);

        Route::get('custom-events/get-custom-events', [CustomEventController::class, 'getCustomEvents'])->name('custom-events.get-custom-events');
        Route::resource('custom-events', CustomEventController::class);

        Route::get('inventory-items/get-inventory-items', [InventoryItemController::class, 'getInventoryItems'])->name('inventory-items.get-inventory-items');
        Route::resource('inventory-items', InventoryItemController::class);

        Route::get('inventory-orders/by-custom-event/{customEvent}', [EventInventoryOrderController::class, 'getOrdersByCustomEvent'])->name('inventory-orders.by-custom-event');
        Route::get('inventory-orders/get-inventory-orders', [EventInventoryOrderController::class, 'getInventoryOrders'])->name('inventory-orders.get-inventory-orders');
        Route::resource('inventory-orders', EventInventoryOrderController::class);

        Route::get('payments/by-custom-event/{customEvent}', [PaymentController::class, 'getPaymentsByCustomEvent'])->name('payments.by-custom-event');        
        Route::get('payments/get-payment-details', [PaymentController::class, 'getPaymentDetails'])->name('payments.get-payment-details');
        Route::resource('payments', PaymentController::class);
    });

    // Customer Portal
    Route::group(['prefix' => 'customer', 'middleware' => ['role:customer'], 'as' => 'customer.'], function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
    });

    // Event Organizer Portal
    Route::group(['prefix' => 'event-organizer', 'middleware' => ['role:event_organizer'], 'as' => 'event_organizer.'], function () {
        Route::get('/dashboard', [EventOrganizerDashboardController::class, 'index'])->name('dashboard');

        Route::get('event-types/get-event-types', [EventOrganizerEventTypeController::class, 'getEventTypes'])->name('event-types.get-event-types');
        Route::resource('event-types', EventOrganizerEventTypeController::class);

        Route::get('event-requests/get-event-requests', [EventOrganizerEventRequestController::class, 'getEventRequests'])->name('event-requests.get-event-requests');
        Route::resource('event-requests', EventOrganizerEventRequestController::class);

        Route::get('custom-events/get-custom-events', [EventOrganizerCustomEventController::class, 'getCustomEvents'])->name('custom-events.get-custom-events');
        Route::resource('custom-events', EventOrganizerCustomEventController::class);

        Route::post('inventory-items/{item}/place-order', [EventOrganizerInventoryItemController::class, 'placeOrder'])->name('inventory-items.place-order');
        Route::get('inventory-items/get-inventory-items', [EventOrganizerInventoryItemController::class, 'getInventoryItems'])->name('inventory-items.get-inventory-items');
        Route::get('inventory-items/{item}/order', [EventOrganizerInventoryItemController::class, 'orderItem'])->name('inventory-items.order');
        Route::resource('inventory-items', EventOrganizerInventoryItemController::class);

        Route::get('inventory-orders/by-custom-event/{customEvent}', [EventOrganizerEventInventoryOrderController::class, 'getOrdersByCustomEvent'])->name('inventory-orders.by-custom-event');
        Route::get('inventory-orders/get-inventory-orders', [EventOrganizerEventInventoryOrderController::class, 'getInventoryOrders'])->name('inventory-orders.get-inventory-orders');
        Route::resource('inventory-orders', EventOrganizerEventInventoryOrderController::class);

        Route::get('payments/by-custom-event/{customEvent}', [EventOrganizerPaymentController::class, 'getPaymentsByCustomEvent'])->name('payments.by-custom-event');        
        Route::get('payments/get-payment-details', [EventOrganizerPaymentController::class, 'getPaymentDetails'])->name('payments.get-payment-details');
        Route::resource('payments', EventOrganizerPaymentController::class);
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
