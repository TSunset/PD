<?php

use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CsvExportController;
use App\Http\Controllers\OrderController;
use App\Models\Course;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $featuredCourses = Course::query()
        ->where('is_active', true)
        ->orderBy('price')
        ->limit(3)
        ->get();

    return view('home', compact('featuredCourses'));
})->name('home');

Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [OrderController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/success', [OrderController::class, 'success'])->name('orders.success');
    Route::get('/orders/{order}/download-contract', [ContractController::class, 'downloadUserContract'])
        ->name('orders.download-contract');
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::get('/', [AdminOrderController::class, 'dashboard'])->name('dashboard');
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
        Route::get('/orders/{order}/download-contract', [ContractController::class, 'downloadAdminContract'])
            ->name('orders.download-contract');
        Route::get('/orders/{order}/download-csv', [CsvExportController::class, 'downloadOrderCsv'])
            ->name('orders.download-csv');
        Route::get('/export/orders.csv', [CsvExportController::class, 'exportAll'])->name('orders.export');
    });
