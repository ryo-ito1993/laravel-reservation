<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController,ContactController,PlanController,ReservationController,
    Admin\ContactController as AdminContactController,
    Admin\ReservationSlotController,
    Admin\PlanController as AdminPlanController,
    Admin\ReservationController as AdminReservationController,
};

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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::view('/', 'top')->name('top');
Route::view('access', 'access')->name('access');
Route::view('rooms', 'rooms')->name('rooms');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('contact')->name('contact.')->controller(ContactController::class)->group(function () {
    Route::get('', 'create')->name('create');
    Route::post('confirm', 'confirm')->name('confirm');
    Route::post('complete', 'send')->name('send');
});

Route::resource('plans', PlanController::class)->only(['index', 'show']);

Route::prefix('reservation')->name('reservation.')->controller(ReservationController::class)->group(function (){
    Route::get('calender/{plan}/{room}', 'calender')->name('calender');
    Route::get('create/{plan}/{slot}', 'create')->name('create');
    Route::post('confirm/{plan}/{slot}', 'confirm')->name('confirm');
    Route::post('send/{plan}/{slot}', 'send')->name('send');
    Route::get('complete/{plan}/{slot}', 'complete')->name('complete');
});

Route::get('/calenders/{plan}/{room}', [\App\Http\Controllers\CalenderController::class, 'index']);

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('contacts', AdminContactController::class)->only(['index', 'show']);
    Route::patch('/contacts/{contact}/updateStatus', [AdminContactController::class, 'updateStatus'])->name('contacts.updateStatus');
    Route::resource('reservation_slots', ReservationSlotController::class);
    Route::resource('plans', AdminPlanController::class);
    Route::resource('reservations', AdminReservationController::class)->only(['index', 'show']);
    Route::patch('/reservations/{reservation}/updateStatus', [AdminReservationController::class, 'updateStatus'])->name('reservations.updateStatus');
    Route::patch('/admin/reservations/{reservation}/note', [AdminReservationController::class, 'updateNote'])->name('reservations.updateNote');
});

require __DIR__ . '/auth.php';
