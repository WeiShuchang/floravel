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
use App\Http\Middleware\RestrictAdminAccess;
use App\Http\Middleware\RestrictUserAccess;

Route::middlewareGroup('restrictAdmin', [
    RestrictAdminAccess::class,
]);

Route::middlewareGroup('restrictUser', [
    RestrictUserAccess::class,
]);



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



    Route::middleware('restrictAdmin')->group(function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/create/{flower}', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my_orders');
        Route::get('/reservations/search', [OrderController::class, 'search'])->name('completed.reservations.search');
        Route::get('/orders/export/pdf', [OrderController::class, 'exportToPDF'])->name('orders.export_pdf');

    
    });
    
    Route::middleware('restrictUser')->group(function () {
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
    
      
        Route::get('/all-orders', [OrderController::class, 'showAllPendingOrders'])->name('orders.show_pending_orders');
        Route::get('/all-shipped-orders', [OrderController::class, 'showAllShippedOrders'])->name('orders.show_shipped_orders');
        Route::get('/all-delivered-orders', [OrderController::class, 'showAllDeliveredOrders'])->name('orders.show_delivered_orders');
        Route::post('/orders/{orderId}/ship', [OrderController::class, 'ship'])->name('orders.ship');
        Route::post('/orders/{orderId}/mark-as-delivered', [OrderController::class, 'markAsDelivered'])->name('orders.deliver');
        Route::get('/reports', [OrderController::class, 'reports'])->name('reports.index');
        Route::get('/reservations/search_admin', [OrderController::class, 'search_admin'])->name('reports.search_admin');

            

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
