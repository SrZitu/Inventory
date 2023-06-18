<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeSliderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('frontend.index');
});

Route::get('/dashboard', function () {
    return view('admin.index');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::controller(AdminController::class)->group(function () {
    Route::get('/admin/logout', 'destroy')->name('admin.logout');
    Route::get('/admin/profile', 'profile')->name('admin.profile');
    Route::get('/admin/edit', 'editProfile')->name('admin.edit');
    Route::post('/admin/store', 'storeProfile')->name('store.profile');
    Route::get('/admin/changePassword', 'changePassword')->name('change.password');
    Route::post('/admin/updatePassword', 'updatePassword')->name('update.password');
});



//Home side all routes
Route::controller(HomeSliderController::class)->group(function () {
    Route::get('/home/slide', 'HomeSlider')->name('home.slide');
    Route::post('/update/slider', 'UpdateSlider')->name('update.slider');
});

//About page all routes
Route::controller(AboutController::class)->group(function () {
    Route::get('/about/page', 'aboutPage')->name('about.page');
    Route::post('/update/about', 'UpdateAbout')->name('update.about');
    Route::get('/home/about', 'HomeAbout')->name('home.about');
    Route::get('/home/multiImage', 'multiImagePage')->name('multiImage.page');
    Route::post('/multiImage/store', 'storeMultiImage')->name('storeMultiImage.page');
    Route::get('/multiImage/show', 'showMultiImage')->name('all.multiImage.page');
    Route::get('/multiImage/edit/{id}', 'editMultiImage')->name('multiImage.Edit.page');
    Route::post('/multiImage/update/', 'updateMultiImage')->name('update.multi.image');
    Route::get('/multiImage/delete/{id}', 'DeleteMultiImage')->name('delete.multi.image');
});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
