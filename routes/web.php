<?php

use App\Http\Controllers\BookingsController;
use App\Http\Controllers\GuestsController;
use App\Http\Controllers\HotelsController;
use App\Http\Controllers\PopularRoomsController;
use App\Http\Controllers\PositionsController;
use App\Http\Controllers\HotelFreeRoomsCountController;
use App\Http\Controllers\PositionsCountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\UsersController;
use App\Models\HotelFreeRoomCount;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Dashboard');
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

//Route::get('/dashboard', function () {
//    return Inertia::render('Dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/users', [UsersController::class, 'index'])->name('users.index');
Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
Route::patch('/users/{user}/update', [UsersController::class, 'update'])->name('users.update');
Route::delete('/users/{user}/delete', [UsersController::class, 'delete'])->name('users.delete');
Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
Route::post('/users/store', [UsersController::class, 'store'])->name('users.store');
Route::get('/users/sort', [UsersController::class, 'sort'])->name('users.sort');

Route::get('/hotels', [HotelsController::class, 'index'])->name('hotels.index');
Route::get('/hotels/{hotel}/edit', [HotelsController::class, 'edit'])->name('hotels.edit');
Route::patch('/hotels/{hotel}/update', [HotelsController::class, 'update'])->name('hotels.update');
Route::delete('/hotels/{hotel}/delete', [HotelsController::class, 'delete'])->name('hotels.delete');
Route::get('/hotels/create', [HotelsController::class, 'create'])->name('hotels.create');
Route::post('/hotels/store', [HotelsController::class, 'store'])->name('hotels.store');
Route::get('/hotels/sort', [HotelsController::class, 'sort'])->name('hotels.sort');

Route::get('/positions', [PositionsController::class, 'index'])->name('positions.index');
Route::get('/positions/{position}/edit', [PositionsController::class, 'edit'])->name('positions.edit');
Route::patch('/positions/{position}/update', [PositionsController::class, 'update'])->name('positions.update');
Route::delete('/positions/{position}/delete', [PositionsController::class, 'delete'])->name('positions.delete');
Route::get('/positions/create', [PositionsController::class, 'create'])->name('positions.create');
Route::post('/positions/store', [PositionsController::class, 'store'])->name('positions.store');
Route::get('/positions/sort', [PositionsController::class, 'sort'])->name('positions.sort');

Route::get('/rooms', [RoomsController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{room}/edit', [RoomsController::class, 'edit'])->name('rooms.edit');
Route::patch('/rooms/{room}/update', [RoomsController::class, 'update'])->name('rooms.update');
Route::delete('/rooms/{room}/delete', [RoomsController::class, 'delete'])->name('rooms.delete');
Route::get('/rooms/create', [RoomsController::class, 'create'])->name('rooms.create');
Route::post('/rooms/store', [RoomsController::class, 'store'])->name('rooms.store');
Route::get('/rooms/sort', [RoomsController::class, 'sort'])->name('rooms.sort');

Route::get('/guests', [GuestsController::class, 'index'])->name('guests.index');
Route::get('/guests/{guest}/edit', [GuestsController::class, 'edit'])->name('guests.edit');
Route::patch('/guests/{guest}/update', [GuestsController::class, 'update'])->name('guests.update');
Route::delete('/guests/{guest}/delete', [GuestsController::class, 'delete'])->name('guests.delete');
Route::get('/guests/create', [GuestsController::class, 'create'])->name('guests.create');
Route::post('/guests/store', [GuestsController::class, 'store'])->name('guests.store');
Route::get('/guests/sort', [GuestsController::class, 'sort'])->name('guests.sort');

Route::get('/bookings', [BookingsController::class, 'index'])->name('bookings.index');
Route::get('/bookings/{booking}/edit', [BookingsController::class, 'edit'])->name('bookings.edit');
Route::patch('/bookings/{booking}/update', [BookingsController::class, 'update'])->name('bookings.update');
Route::delete('/bookings/{booking}/delete', [BookingsController::class, 'delete'])->name('bookings.delete');
Route::get('/bookings/create', [BookingsController::class, 'create'])->name('bookings.create');
Route::post('/bookings/store', [BookingsController::class, 'store'])->name('bookings.store');
Route::get('/bookings/sort', [BookingsController::class, 'sort'])->name('bookings.sort');

Route::get('/popular-rooms', [PopularRoomsController::class, 'index'])->name('popularRooms.index');
Route::get('/popular-rooms/sort', [PopularRoomsController::class, 'sort'])->name('popularRooms.sort');

Route::get('/positions-count', [PositionsCountController::class, 'index'])->name('positionsCount.index');
Route::get('/positions-count/sort', [PositionsCountController::class, 'sort'])->name('positionsCount.sort');

Route::get('/free-rooms', [HotelFreeRoomsCountController::class, 'index'])->name('freeRooms.index');
Route::get('/free-rooms/sort', [HotelFreeRoomsCountController::class, 'sort'])->name('freeRooms.sort');


require __DIR__.'/auth.php';
