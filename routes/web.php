<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\UserActivityController;
use App\Http\Controllers\Admin\CompanyProfileController;
use App\Http\Controllers\Admin\Menu\ContentController;
use App\Http\Controllers\Admin\Menu\MenuController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// public pages
Route::get('/', [PublicPageController::class, 'index'])->name('public-home');
Route::get('/about', [PublicPageController::class, 'showAbout'])->name('public-about');
Route::get('/contact', [PublicPageController::class, 'showContact'])->name('public-contact');

// authentication
Auth::routes([
    'register' => false,
    'verify' => true,
]);

// authenticated
Route::middleware('auth', 'verified')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('user-profile');
    Route::get('/user-activities', [UserActivityController::class, 'index'])->name('user-activities');
    Route::post('/user-activites', [UserActivityController::class, 'getActivity_ByID'])->name('user-activity-get');

    // administrator page
    Route::group([
        'prefix' => 'admin',
        'as' => 'admin.',
        'middleware' => ['role:administrator'],
    ], function () {
        Route::get('/options', [OptionController::class, 'index'])->name('options-index');
        Route::get('/company-profile', [CompanyProfileController::class, 'index'])->name('company-profile-index');
        Route::get('/users', [UserController::class, 'index'])->name('users-index');
        Route::get('/web-navigations', [MenuController::class, 'index'])->name('navigations-index');

        Route::get('/manage-contents', [ContentController::class, 'manageContents'])->name('contents-manage');
    });

    Route::group([
        'as' => 'admin.',
    ], function () {
        // contents
        Route::get('/contents', [ContentController::class, 'index'])->name('contents-index');
        Route::post('/contents', [ContentController::class, 'store'])->name('contents-store');
        Route::put('/contents', [ContentController::class, 'update'])->name('contents-store');

        // image upload handler
        Route::post('/contents/upload-image', [ContentController::class, 'uploadImage'])->name('contents-image-upload');

        // create content
        Route::get('/contents/{main}/{sub}/create', [ContentController::class, 'create'])->name('contents-create');
        Route::get('/contents/{main}/create', [ContentController::class, 'create'])->name('contents-create');

        // edit content
        Route::get('/contents/{id}/edit', [ContentController::class, 'edit'])->name('contents-edit');

        // show content
        Route::get('/contents/{main}/{sub}', [ContentController::class, 'show'])->name('contents-show');
        Route::get('/contents/{main}', [ContentController::class, 'show'])->name('contents-show');
    });
});

Route::get('/{main}/{sub}', [PublicPageController::class, 'show'])->name('public-show')->where('main', '[a-z0-9-]+')->where('sub', '[a-z0-9-]+');
Route::get('/{main}', [PublicPageController::class, 'show'])->name('public-show')->where('main', '[a-z0-9-]+');
