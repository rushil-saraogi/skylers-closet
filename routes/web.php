<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\MetaDataController;
use App\Http\Controllers\ClosetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    // Routing - 
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/explore', [DashboardController::class, 'explore'])->name('explore');
    Route::get('/feed', [DashboardController::class, 'feed'])->name('feed');
    Route::get('/user/{user}', [UserController::class, 'UserProfile'])->name('user-profile');

    // Closet Forms
    Route::get('/closets/{closet}', [ClosetController::class, 'show'])->name('show-closet');
    Route::post('/closets', [ClosetController::class, 'create'])->name('create-closet');
    Route::put('/closets/{closet}', [ClosetController::class, 'update'])->name('update-closet');
    Route::delete('/closets/{closet}', [ClosetController::class, 'delete'])->name('delete-closet');
    
    // Item Forms
    Route::post('/closets/{closet}/items', [ItemController::class, 'create'])->name('create-item');
    Route::put('/closets/{closet}/items/{item}', [ItemController::class, 'update'])->name('update-item');
    Route::delete('/closets/{closet}/items/{item}', [ItemController::class, 'delete'])->name('delete-item');

    // Message Forms
    Route::post('/closets/{closet}/messages', [MessageController::class, 'create'])->name('create-message');
    
    // Misc
    // Routes prefixed with API do not follow the inertia pattern
    Route::get('/api/links/get-meta', [MetaDataController::class, 'getMetaData'])->name('get-meta');
    Route::post('/api/images/upload', [ImageController::class, 'upload'])->name('upload-image');
    Route::put('/api/closets/{closet}/items/{item}', [ItemController::class, 'updateWithoutIntertia'])->name('api-update-item');
});

// Catch all route for pubsites
Route::get('/{slug}', [PageController::class, 'pubsite'])->name('pubsite');