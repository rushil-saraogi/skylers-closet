<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\MetaDataController;
use App\Http\Controllers\ClosetController;
use App\Http\Controllers\ImageController;
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
    Route::get('/dashboard', [ClosetController::class, 'dashboard'])->name('dashboard');
    Route::get('/explore', [ClosetController::class, 'explore'])->name('explore');
    Route::get('/feed', [ClosetController::class, 'feed'])->name('feed');
    Route::get('/page-editor/{id}', [ClosetController::class, 'pageEditor'])->name('page-editor');

    // Closet Forms
    Route::post('/closets', [ClosetController::class, 'create'])->name('create-closet');
    Route::put('/closets/{closet}', [ClosetController::class, 'update'])->name('update-closet');
    Route::delete('/closets/{closet}', [ClosetController::class, 'delete'])->name('delete-closet');
    
    // Item Forms
    Route::post('/closets/{closet}/items', [ItemController::class, 'create'])->name('create-item');
    Route::put('/closets/{closet}/items/{item}', [ItemController::class, 'update'])->name('update-item');
    Route::delete('/closets/{closet}/items/{item}', [ItemController::class, 'delete'])->name('delete-item');
    
    // Misc
    // Routes prefixed with API do not follow the inertia pattern
    Route::get('/api/links/get-meta', [MetaDataController::class, 'getMetaData'])->name('get-meta');
    Route::get('/api/closets/valid-slug', [ClosetController::class, 'validateSlug'])->name('validate-slug');
    Route::post('/api/images/upload', [ImageController::class, 'upload'])->name('upload-image');
});

// Catch all route for pubsites
Route::get('/{slug}', [PageController::class, 'pubsite'])->name('pubsite');