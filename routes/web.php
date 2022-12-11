<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\MetaDataController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ClosetController;
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
Route::get('/', [DashboardController::class, 'explore'])->name('welcome');
Route::get('/explore', [DashboardController::class, 'explore'])->name('explore');
Route::get('/search', [DashboardController::class, 'search'])->name('search');
Route::get('/closets/{closet}', [ClosetController::class, 'show'])->name('show-closet');
Route::get('/user/{user}', [UserController::class, 'UserProfile'])->name('user-profile');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    // Routing - 
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/feed', [DashboardController::class, 'feed'])->name('feed');

    // Closet Forms
    Route::post('/closets', [ClosetController::class, 'create'])->name('create-closet');
    Route::put('/closets/{closet}', [ClosetController::class, 'update'])->name('update-closet');
    Route::delete('/closets/{closet}', [ClosetController::class, 'delete'])->name('delete-closet');
    Route::post('/closets/{closet}/follow', [ClosetController::class, 'follow'])->name('follow-closet');
    
    // Item Forms
    Route::post('/closets/{closet}/items', [ItemController::class, 'create'])->name('create-item');
    Route::put('/closets/{closet}/items/{item}', [ItemController::class, 'update'])->name('update-item');
    Route::delete('/closets/{closet}/items/{item}', [ItemController::class, 'delete'])->name('delete-item');

    // Message Forms
    Route::post('/closets/{closet}/messages', [MessageController::class, 'create'])->name('create-message');

    // User Froms
    Route::post('/users/{user}/follow', [UserController::class, 'follow'])->name('follow');
    
    // Misc
    // Routes prefixed with API do not follow the inertia pattern
    Route::delete('/api/closets/{closet}/items/{item}/remove-by-url', [ItemController::class, 'removeByUrl'])->name('remove-item-by-url');
    Route::post('/api/closets/{closet}/items/{item}/copy', [ItemController::class, 'copy'])->name('copy-item');
    Route::get('/api/links/get-meta', [MetaDataController::class, 'getMetaData'])->name('get-meta');
    Route::get('/api/search', [SearchController::class, 'search'])->name('search-query');
    Route::get('/api/closets/current-user', [ClosetController::class, 'currentUser'])->name('current-user-closets');
    Route::put('/api/closets/{closet}/items/{item}', [ItemController::class, 'updateWithoutIntertia'])->name('api-update-item');
});

// Catch all route for pubsites
Route::get('/{slug}', [PageController::class, 'pubsite'])->name('pubsite');