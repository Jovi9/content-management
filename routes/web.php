<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CompanyProfileController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\UserTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicPageController;
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

require __DIR__ . '/auth.php';

// Route::resource('/', PublicPageController::class);

Route::middleware('auth', 'verified')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

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
        Route::get('/menus', [MenuController::class, 'index'])->name('menus-index');
    });

    // administrator and staff page
    // content creation
    Route::group([
        'prefix' => 'user',
        'as' => 'user.',
        'middleware' => ['role:administrator|staff'],
    ], function () {
        // index page
        Route::get('/contents', [ContentController::class, 'index'])->name('contents-index');
        // store content
        Route::post('/contents', [ContentController::class, 'store'])->name('contents-store');
        // update content
        Route::put('/contents/{id}', [ContentController::class, 'update'])->name('contents-update');
        // store img file
        Route::post('/contents/upload', [ContentController::class, 'imageUpload'])->name('img-upload');
        // show content of main menu
        Route::get('/contents/{menu}', [ContentController::class, 'show'])->name('show-content-main');
        // create content of main menu
        Route::get('/contents/{menu}/create', [ContentController::class, 'create'])->name('create-content');
        // edit main content
        Route::get('/contents/{menu}/{id}/edit', [ContentController::class, 'edit'])->name('edit-content');
        // show sub menu content
        Route::get('/contents/{menu}/{sub_menu}', [ContentController::class, 'showSubContent'])->name('show-content-sub');
        // create sub menu content
        Route::get('/contents/{menu}/{sub_menu}/create', [ContentController::class, 'createSubContent'])->name('create-sub-content');
        // edit sub content
        Route::get('/contents/{menu}/{sub_menu}/{id}/edit', [ContentController::class, 'editSubContent'])->name('edit-sub-content');
    });
});

Route::get('/', [PublicPageController::class, 'index'])->name('public-index');
Route::get('/{menu}', [PublicPageController::class, 'show'])->name('public-main_con-show');
Route::get('/{menu}/{sub_menu}', [PublicPageController::class, 'show_s'])->name('public-sub_con-show');
