<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\MetaDataController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public routes
Route::get('/', [DashboardController::class, 'home'])->name('home');

Route::get('/closets/{closet}', [ClosetController::class, 'show'])->name('show-closet');
Route::get('/user/{user}', [UserController::class, 'UserProfile'])->name('user-profile');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    // Routing - 
    Route::get('/hotels', [DashboardController::class, 'hotels'])->name('hotels');
    Route::get('/design', [DashboardController::class, 'design'])->name('design');
    Route::get('/trips', [DashboardController::class, 'trips'])->name('trips');
    Route::get('/employees', [DashboardController::class, 'employees'])->name('employees');
    Route::get('/design', [DashboardController::class, 'design'])->name('design');
    Route::get('/guests', [DashboardController::class, 'guests'])->name('guests');
    Route::get('/outlets', [DashboardController::class, 'outlets'])->name('outlets');
    Route::get('/room-service', [DashboardController::class, 'roomService'])->name('room-service');
    Route::get('/house-keeping', [DashboardController::class, 'houseKeeping'])->name('house-keeping');

    // Hotel Forms
    Route::post('/hotels', [HotelController::class, 'create'])->name('create-hotel');
    Route::post('/hotels/{hotel}/logo', [ClosetController::class, 'addLogo'])->name('add-logo');

    // Trip Forms
    Route::post('/trips', [TripController::class, 'create'])->name('create-trip');

    // User forms
    Route::post('/user', [UserController::class, 'create'])->name('create-user');
    Route::put('/user/{user}', [UserController::class, 'update'])->name('update-user');
    Route::put('/users/{user}/complete-onboarding', [UserController::class, 'completeOnboarding'])->name('complete-onboarding');
    Route::delete('/users/{user}', [UserController::class, 'delete'])->name('delete-user');
    Route::post('/closets/{closet}/follow', [ClosetController::class, 'follow'])->name('follow-closet');
    
    // Item Forms
    Route::post('/closets/{closet}/items', [ItemController::class, 'create'])->name('create-item');
    Route::put('/closets/{closet}/items/{item}', [ItemController::class, 'update'])->name('update-item');
    Route::delete('/closets/{closet}/items/{item}', [ItemController::class, 'delete'])->name('delete-item');

    // Message Forms
    Route::post('/closets/{closet}/messages', [MessageController::class, 'create'])->name('create-message');
    
    // Misc
    // Routes prefixed with API do not follow the inertia pattern
    Route::delete('/api/closets/{closet}/items/{item}/remove-by-url', [ItemController::class, 'removeByUrl'])->name('remove-item-by-url');
    Route::post('/api/closets/{closet}/items/{item}/copy', [ItemController::class, 'copy'])->name('copy-item');
    Route::get('/api/links/get-meta', [MetaDataController::class, 'getMetaData'])->name('get-meta');
    Route::get('/api/closets/current-user', [ClosetController::class, 'currentUser'])->name('current-user-closets');
    Route::put('/api/closets/{closet}/items/{item}', [ItemController::class, 'updateWithoutIntertia'])->name('api-update-item');
});
