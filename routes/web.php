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

// authentification 
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/', [AuthController::class, 'login']);

    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    // Dashboard
   Route::get('/admin/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Publishers
    Route::resource('publishers', PublisherController::class);
}); 
    // Members
    Route::middleware('auth')->group(function () {
    // ... routes existantes ...
    Route::resource('members', MemberController::class);
});
    // Games
    Route::middleware('auth')->group(function () {
    // ... routes existantes ...
    Route::resource('games', GameController::class);
});
    // game stock
    Route::middleware('auth')->group(function () {
    // ... routes existantes ...
    Route::resource('gamestock', GameStockController::class);
}); 
    // Stock In
    Route::middleware('auth')->group(function () {
    // ... routes existantes ...
    Route::resource('stockin', StockInController::class);
});
    // Sales
    Route::middleware('auth')->group(function () {
    // ... routes existantes ...
    Route::resource('sales', SaleController::class);
});
    // Reports
    Route::middleware('auth')->group(function () {
    // ... routes existantes ...
    Route::get('reports/sales', [ReportController::class, 'salesReport'])->name('reports.sales');
    Route::get('reports/stockin', [ReportController::class, 'stockInReport'])->name('reports.stockin');
});
    

  //Route::middleware('auth')->group(function () {
    //Route::get('/admin/dashboard', function () {
      //  return view('admin.dashboard.list');  // ← changer ici
    //})->name('dashboard');
//});
// Logout (protégé par auth)
//Route::post('/logout', [AuthController::class, 'logout'])
  //  ->name('logout')
   // ->middleware('auth');


//Route::get('admin/dashboard', [DashboardController::class, 'dashboard']);
//Route::middleware('auth')->group(function () {
    // On utilise le contrôleur pour charger la vue complexe
  //  Route::get('admin/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
//});