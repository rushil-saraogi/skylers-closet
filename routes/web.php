<?php

use App\Http\Controllers\TileController;
use App\Http\Controllers\MetaDataController;
use App\Http\Controllers\PageController;
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
    Route::get('/dashboard', [PageController::class, 'list'])->name('dashboard');
    Route::get('/page-editor/{id}', [PageController::class, 'pageEditor'])->name('page-editor');

    // Page Forms
    Route::post('/pages', [PageController::class, 'create'])->name('create-page');
    Route::put('/pages/{pageId}', [PageController::class, 'update'])->name('update-page');
    Route::delete('/pages/{pageId}', [PageController::class, 'delete'])->name('delete-page');
    
    // Tile Forms
    Route::post('/pages/{pageId}/tiles/{tileType}', [TileController::class, 'create'])->name('create-tile');
    Route::put('/pages/{pageId}/tiles/{tileId}', [TileController::class, 'update'])->name('update-tile');
    Route::delete('/pages/{pageId}/tiles/{tileId}', [TileController::class, 'delete'])->name('delete-tile');
    
    // Misc
    // Routes prefixed with API do not follow the inertia pattern
    Route::get('/api/links/get-meta', [MetaDataController::class, 'getMetaData'])->name('get-meta');
    Route::get('/api/pages/valid-slug', [PageController::class, 'validateSlug'])->name('validate-slug');
    Route::post('/api/images/upload', [ImageController::class, 'upload'])->name('upload-image');
});

// Catch all route for pubsites
Route::get('/{slug}', [PageController::class, 'pubsite'])->name('pubsite');