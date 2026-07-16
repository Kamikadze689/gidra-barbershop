<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\VacancyApplicationController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\MasterController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\VacancyController as AdminVacancyController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/vacancies', [VacancyController::class, 'index'])->name('vacancies');
Route::post('/vacancies/apply', [VacancyController::class, 'apply'])->name('vacancies.apply');


Route::get('/booking/{master:slug?}', [BookingController::class, 'create'])->name('booking');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/available-slots', [BookingController::class, 'availableSlots']);


Route::get('/review/{token}', [BookingController::class, 'showReviewForm'])->name('review.form');
Route::post('/review/{token}', [BookingController::class, 'storeReview'])->name('review.store');


Route::get('/login', [AuthenticatedSessionController::class, 'create'])
     ->name('login')
     ->middleware('guest');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
     ->name('login')
     ->middleware('guest');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
     ->name('logout');


Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('masters', MasterController::class)->parameters([
     'masters' => 'master'
     ])->except(['show']);
    Route::resource('services', ServiceController::class);
    Route::post('services/reorder', [ServiceController::class, 'reorder'])->name('services.reorder');
    Route::resource('vacancies', AdminVacancyController::class);

    Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings');
    Route::patch('bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.status');
    Route::delete('bookings/{booking}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');

    Route::get('vacancy-applications', [VacancyApplicationController::class, 'index'])->name('vacancy-applications');
    Route::patch('vacancy-applications/{application}/mark-reviewed', [VacancyApplicationController::class, 'markReviewed'])->name('vacancy-applications.mark-reviewed');
    Route::delete('vacancy-applications/{application}', [VacancyApplicationController::class, 'destroy'])->name('vacancy-applications.destroy');

    Route::get('reviews', [AdminReviewController::class, 'index'])->name('reviews');
    Route::post('reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::delete('reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::get(
    'bookings/export',
     [AdminBookingController::class, 'exportForm']
     )->name('bookings.export.form');

     Route::post(
     'bookings/export',
     [AdminBookingController::class, 'export']
     )->name('bookings.export');
});