<?php

use App\Http\Controllers\Admin\CompanyController as AdminCompanyController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Company\DashboardController as CompanyDashboardController;
use App\Http\Controllers\Company\DriverController;
use App\Http\Controllers\Company\FinanceController;
use App\Http\Controllers\Company\MapController;
use App\Http\Controllers\Company\ReportController;
use App\Http\Controllers\Company\TripController;
use App\Http\Controllers\Company\TruckController;
use App\Http\Controllers\LocationShareController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => auth()->check()
    ? redirect()->route(auth()->user()->isAdmin() ? 'admin.dashboard' : 'firma.dashboard')
    : redirect()->route('login')
);

Route::get('/konum/{token}', [LocationShareController::class, 'show'])->name('location.show');
Route::post('/konum/{token}', [LocationShareController::class, 'store'])->name('location.store');

Route::middleware('guest')->group(function () {
    Route::get('/giris', [LoginController::class, 'show'])->name('login');
    Route::post('/giris', [LoginController::class, 'store']);
});

Route::post('/cikis', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', AdminDashboardController::class)->name('dashboard');
    Route::resource('companies', AdminCompanyController::class)->except(['destroy']);
});

Route::middleware(['auth', 'firma'])->prefix('firma')->name('firma.')->group(function () {
    Route::get('/', CompanyDashboardController::class)->name('dashboard');

    Route::resource('trucks', TruckController::class);
    Route::post('trucks/{truck}/konum', [TruckController::class, 'ping'])->name('trucks.ping');

    Route::resource('drivers', DriverController::class)->except(['show', 'destroy']);

    Route::resource('trips', TripController::class);
    Route::post('trips/{trip}/tamamla', [TripController::class, 'complete'])->name('trips.complete');
    Route::post('trips/{trip}/masraf', [TripController::class, 'storeExpense'])->name('trips.expenses.store');
    Route::delete('trips/{trip}/masraf/{expense}', [TripController::class, 'destroyExpense'])->name('trips.expenses.destroy');

    Route::get('finans', [FinanceController::class, 'index'])->name('finance.index');
    Route::post('finans/gelir', [FinanceController::class, 'storeIncome'])->name('finance.income.store');
    Route::delete('finans/gelir/{income}', [FinanceController::class, 'destroyIncome'])->name('finance.income.destroy');
    Route::post('finans/gider', [FinanceController::class, 'storeExpense'])->name('finance.expense.store');
    Route::delete('finans/gider/{expense}', [FinanceController::class, 'destroyExpense'])->name('finance.expense.destroy');

    Route::get('raporlar', ReportController::class)->name('reports');
    Route::get('harita', MapController::class)->name('map');
});
