<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameStockController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;


// authentification 
Route::middleware('guest')->group(function () {
    // login
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/', [AuthController::class, 'login']);

    //register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    //dashboard
   Route::get('/admin/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    //logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // publishers
    Route::resource('publishers', PublisherController::class);
}); 
    //members
    Route::middleware('auth')->group(function () {
    
    Route::resource('members', MemberController::class);
});
    // Games
    Route::middleware('auth')->group(function () {
    
    Route::resource('games', GameController::class);
});
    // game stock
    Route::middleware('auth')->group(function () {
    
    Route::get('gamestock', [GameStockController::class, 'index'])
    ->name('gamestock.index');
}); 
    //stock In
    Route::middleware('auth')->group(function () {
    
    Route::resource('stockin', StockInController::class);
});
    //Sales
    Route::middleware('auth')->group(function () {
    
    Route::resource('sales', SaleController::class);
});
    //reports
    Route::middleware('auth')->group(function () {
    
    Route::get('reports/sales', [ReportController::class, 'salesReport'])->name('reports.sales');
    Route::get('reports/stockin', [ReportController::class, 'stockInReport'])->name('reports.stockin');
});
    //myprofile
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });

    
    /*Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', function () {
       return view('admin.dashboard.list'); 
    })->name('dashboard'); 
    });*/
