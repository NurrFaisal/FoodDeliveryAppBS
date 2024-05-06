<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RiderController;
use App\Http\Controllers\Api\RestaurantController;



Route::group(['as' => 'api.'], static function () {
    // API for create new rider
    Route::post('rider', [RiderController::class, 'create'])->name('rider.create');
    // API for create new restaurant
    Route::post('restaurant', [RestaurantController::class, 'create'])->name('restaurant.create');
    // API to store new rider's location
    Route::post('rider/location/store', [RiderController::class, 'storeRiderLocation'])->name('location.store');
    // API to get nearby riders
    Route::get('rider/nearby/restaurant/{restaurant_id}', [RiderController::class, 'getNearbyRider'])->name('rider.nearby');
});
