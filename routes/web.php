<?php

use App\Http\Controllers\LinkController;
use App\Http\Controllers\PageController;
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
    Route::get('/dashboard', [PageController::class, 'list'])->name('dashboard');
    Route::get('/page-editor/{id?}', [PageController::class, 'pageEditor'])->name('page-editor');
    Route::post('/pages', [PageController::class, 'create'])->name('create-page');
    Route::post('/pages/{pageId}/links', [LinkController::class, 'create'])->name('create-link');
    Route::get('/api/links/get-meta', [LinkController::class, 'getMetaData'])->name('get-meta');
});