<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FLowerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\FlowerSupplierController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\RedirectBasedOnRole;
use App\Http\Middleware\RedirectIfAuthenticated;



Route::middleware([RedirectIfAuthenticated::class])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    

});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
   

    Route::get('/flowers', [FlowerController::class, 'index'])->name('flowers.index');
    Route::get('/flowers/create', [FlowerController::class, 'create'])->name('flowers.create');
    Route::post('/flowers', [FlowerController::class, 'store'])->name('flowers.store');
    Route::get('/flowers/{flower}', [FlowerController::class, 'show'])->name('flowers.show');
    Route::get('/flowers/{flower}/edit', [FlowerController::class, 'edit'])->name('flowers.edit');
    Route::put('/flowers/{flower}', [FlowerController::class, 'update'])->name('flowers.update');
    Route::delete('/flowers/{flower}', [FlowerController::class, 'destroy'])->name('flowers.destroy');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('/suppliers/{supplier}', [SupplierController::class, 'show'])->name('suppliers.show');
    Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

    Route::get('/flowersuppliers', [FlowerSupplierController::class, 'index'])->name('flowersuppliers.index');
    Route::get('/flowersuppliers/create', [FlowerSupplierController::class, 'create'])->name('flowersuppliers.create');
    Route::post('/flowersuppliers', [FlowerSupplierController::class, 'store'])->name('flowersuppliers.store');
    Route::get('/flowersuppliers/{flowersupplier}', [FlowerSupplierController::class, 'show'])->name('flowersuppliers.show');
    Route::get('/flowersuppliers/{flowersupplier}/edit', [FlowerSupplierController::class, 'edit'])->name('flowersuppliers.edit');
    Route::put('/flowersuppliers/{flowersupplier}', [FlowerSupplierController::class, 'update'])->name('flowersuppliers.update');
    Route::delete('/flowersuppliers/{flowersupplier}', [FlowerSupplierController::class, 'destroy'])->name('flowersuppliers.destroy');

    // Define routes for index, create, store, show, edit, update, and destroy methods
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create/{flower}', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my_orders');
    Route::get('/all-orders', [OrderController::class, 'showAllPendingOrders'])->name('orders.show_pending_orders');
    Route::get('/all-shipped-orders', [OrderController::class, 'showAllShippedOrders'])->name('orders.show_shipped_orders');
    Route::get('/all-delivered-orders', [OrderController::class, 'showAllDeliveredOrders'])->name('orders.show_delivered_orders');
    Route::post('/orders/{orderId}/ship', [OrderController::class, 'ship'])->name('orders.ship');
    Route::post('/orders/{orderId}/mark-as-delivered', [OrderController::class, 'markAsDelivered'])->name('orders.deliver');
    Route::get('/reservations/search', [OrderController::class, 'search'])->name('completed.reservations.search');
    Route::get('/orders/export/pdf', [OrderController::class, 'exportToPDF'])->name('orders.export_pdf');

    


    
    Route::middleware([RedirectBasedOnRole::class])->group(function () {
    // Routes for both users and administrators

    // User-specific routes

});

});


Route::middleware(['auth', 'verified'])->group(function () {

    // Admin routes
    Route::get('/administrator', function () {
        if (auth()->user()->role !== 'admin') {
            abort(403); // or redirect to unauthorized page
        }
        return view('administrator.admin_homepage');
    })->name('administrator');

    // User routes
    Route::get('/user', function () {
        if (auth()->user()->role !== 'user') {
            abort(403); // or redirect to unauthorized page
        }
        return view('customer.customer_homepage');
    })->name('user');
    
});

require __DIR__.'/auth.php';
