<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CompanyProfileController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\UserTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserLogActivityController;
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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/activity_logs', [UserLogActivityController::class, 'index'])->name('activity_log');

    // administrator page
    Route::group([
        'prefix' => 'admin',
        'as' => 'admin.',
        'middleware' => ['role:administrator'],
    ], function () {
        Route::resource('/company_profile', CompanyProfileController::class);
        Route::resource('/users', UserController::class);
        Route::resource('/user_types', UserTypeController::class);
        Route::resource('/departments', DepartmentController::class);
    });
});

require __DIR__ . '/auth.php';
