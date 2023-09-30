<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\ReservationSlotController;
use App\Http\Controllers\Admin\PlanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('top');
})->name('top');

Route::get('/access', function () {
    return view('access');
})->name('access');

Route::get('/rooms', function () {
    return view('rooms');
})->name('rooms');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('contact')
    ->name('contact.')
    ->controller(ContactController::class)
    ->group(function () {
        Route::get('', 'create')->name('create');
        Route::post('confirm', 'confirm')->name('confirm');
        Route::post('complete', 'send')->name('send');
    });

Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
    Route::get('/contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
    Route::patch('/contacts/{contact}/updateStatus', [AdminContactController::class, 'updateStatus'])->name('contacts.updateStatus');

    Route::get('/reservation_slots', [ReservationSlotController::class, 'index'])->name('reservation_slots.index');
    Route::get('/reservation_slots/create', [ReservationSlotController::class, 'create'])->name('reservation_slots.create');
    Route::post('/reservation_slots', [ReservationSlotController::class, 'store'])->name('reservation_slots.store');
    Route::get('reservation_slots/{slot}/edit', [ReservationSlotController::class, 'edit'])->whereNumber('slot')->name('reservation_slots.edit');
    Route::put('reservation_slots/{slot}', [ReservationSlotController::class, 'update'])->whereNumber('slot')->name('reservation_slots.update');
    Route::delete('reservation_slots/{slot}', [ReservationSlotController::class, 'destroy'])->whereNumber('slot')->name('reservation_slots.destroy');

    Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
    Route::get('/plans/create', [PlanController::class, 'create'])->name('plans.create');
    Route::post('/plans', [PlanController::class, 'store'])->name('plans.store');
    Route::get('/plans/{plan}', [PlanController::class, 'show'])->name('plans.show');
    Route::get('plans/{plan}/edit', [PlanController::class, 'edit'])->whereNumber('plan')->name('plans.edit');
    Route::put('plans/{plan}', [PlanController::class, 'update'])->whereNumber('plan')->name('plans.update');
    Route::delete('plans/{plan}', [PlanController::class, 'destroy'])->whereNumber('plan')->name('plans.destroy');
});

require __DIR__ . '/auth.php';
