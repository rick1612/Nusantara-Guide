<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TransportationController;

// ─── AUTH ────────────────────────────────────────────────────
Route::get('/', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ─── MAIN HOME ───────────────────────────────────────────────
Route::get('/home', [PlaceController::class, 'index'])->name('home');

// ─── EXPLORE ─────────────────────────────────────────────────
Route::get('/explore', [ProvinceController::class, 'index'])->name('explore');
Route::get('/explore/{slug}', [ProvinceController::class, 'show'])->name('province.show');
Route::get('/explore/{province}/{region}', [ProvinceController::class, 'region'])->name('region.show');

// ─── PLACES ──────────────────────────────────────────────────
Route::get('/places', [PlaceController::class, 'browse'])->name('places.browse');
Route::get('/place/{id}', [PlaceController::class, 'show'])->name('place.show');

// ─── ITINERARIES ─────────────────────────────────────────────
// IMPORTANT: /itinerary/create MUST come before /itinerary/{slug}
// so Laravel doesn't treat "create" as a slug value
Route::get('/itineraries', [ItineraryController::class, 'index'])->name('itinerary.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/itinerary/create', [ItineraryController::class, 'create'])->name('itinerary.create');
    Route::post('/itinerary', [ItineraryController::class, 'store'])->name('itinerary.store');
    Route::get('/my-itineraries', [ItineraryController::class, 'myPosts'])->name('itinerary.my');
    Route::get('/itinerary/{slug}/edit', [ItineraryController::class, 'edit'])->name('itinerary.edit');
    Route::put('/itinerary/{slug}', [ItineraryController::class, 'update'])->name('itinerary.update');
    Route::delete('/itinerary/{slug}', [ItineraryController::class, 'destroy'])->name('itinerary.destroy');
    Route::post('/itinerary/{id}/like', [ItineraryController::class, 'toggleLike'])->name('itinerary.like');
    Route::post('/itinerary/{id}/save', [ItineraryController::class, 'toggleSave'])->name('itinerary.save');
    Route::post('/itinerary/{id}/comment', [ItineraryController::class, 'comment'])->name('itinerary.comment');
    Route::post('/itinerary/{id}/copy', [ItineraryController::class, 'copy'])->name('itinerary.copy');
});

// Public itinerary view — AFTER the auth group so /create is caught first
Route::get('/itinerary/{slug}', [ItineraryController::class, 'show'])->name('itinerary.show');

// ─── AUTHENTICATED ROUTES ─────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    // Places interactions
    Route::post('/place/{id}/review', [ReviewController::class, 'store'])->name('review.store');
    Route::post('/place/{id}/favorite', [FavoriteController::class, 'toggle'])->name('favorite.toggle');

    // Profile
    Route::get('/profile/{id?}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/follow/{id}', [ProfileController::class, 'toggleFollow'])->name('follow.toggle');

    // Hotel Bookings
    Route::get('/booking/room/{roomId}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/{id}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.my');
    Route::post('/booking/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
    Route::get('/admin/bookings', [BookingController::class, 'adminIndex'])->name('admin.bookings');
    Route::post('/admin/bookings/{id}/status', [BookingController::class, 'updateStatus'])->name('admin.bookings.status');

    // Transportation
    Route::get('/transportation/flight/{flight}/book', [TransportationController::class, 'bookFlight'])->name('transportation.flight.book');
    Route::post('/transportation/flight/store', [TransportationController::class, 'storeFlight'])->name('transportation.flight.store');
    Route::get('/transportation/flight/confirm/{id}', [TransportationController::class, 'confirmFlight'])->name('transportation.flight.confirm');
    Route::post('/transportation/flight/{id}/cancel', [TransportationController::class, 'cancelFlight'])->name('transportation.flight.cancel');
    Route::get('/transportation/train/{train}/book', [TransportationController::class, 'bookTrain'])->name('transportation.train.book');
    Route::post('/transportation/train/store', [TransportationController::class, 'storeTrain'])->name('transportation.train.store');
    Route::get('/transportation/train/confirm/{id}', [TransportationController::class, 'confirmTrain'])->name('transportation.train.confirm');
    Route::post('/transportation/train/{id}/cancel', [TransportationController::class, 'cancelTrain'])->name('transportation.train.cancel');
    Route::get('/my-transport-bookings', [TransportationController::class, 'myBookings'])->name('transportation.my');
});

// Transportation search (public)
Route::get('/transportation', [TransportationController::class, 'index'])->name('transportation.index');

// ─── BUDGET CALCULATOR ───────────────────────────────────────
Route::get('/budget-calculator', [\App\Http\Controllers\BudgetCalculatorController::class, 'index'])->name('budget.index');
Route::get('/budget-calculator/result', [\App\Http\Controllers\BudgetCalculatorController::class, 'calculate'])->name('budget.calculate');

// ─── SEASONAL GUIDE ──────────────────────────────────────────
Route::get('/seasonal-guide', [\App\Http\Controllers\SeasonalGuideController::class, 'index'])->name('seasonal.index');
Route::get('/seasonal-guide/show', [\App\Http\Controllers\SeasonalGuideController::class, 'show'])->name('seasonal.show');