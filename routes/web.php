<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeSliderController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\FooterController;
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
    Route::post('/multiImage/update', 'updateMultiImage')->name('update.multi.image');
    Route::get('/multiImage/delete/{id}', 'DeleteMultiImage')->name('delete.multi.image');
});

//Portfolio page all routes
Route::controller(PortfolioController::class)->group(function () {
    Route::get('/portfolio/all/page', 'portfolioPage')->name('portfolio_all.page');
    Route::get('/update/portfolio', 'updateportfolio')->name('update.portfolio');
    Route::get('/portfolio/page', 'singlePortfolio')->name('portfolio.page');
    Route::post('/portfolio/store', 'storePortfolio')->name('store.portfolio');
    Route::get('/portfolio/edit/{id}', 'editPortfolio')->name('edit.portfolio');
    Route::post('/portfolio/update', 'updatePortfolio')->name('update.portfolio');
    Route::get('/portfolio/delete/{id}', 'deletePortfolio')->name('delete.portfolio');
     Route::get('/portfolio/details/{id}', 'detailsPortfolio')->name('portfolio.details');

});


//Blog Category page all routes
Route::controller(BlogCategoryController::class)->group(function () {
    Route::get('/blogCategory/all/page', 'blogCategoryPage')->name('blog_category_all.page');
    Route::get('/blogCategory/page', 'singleBlogCategory')->name('blog_category.page');
    Route::post('/blogCategory/store', 'storeBlogCategory')->name('store.blogCategory');
    Route::get('/blogCategory/edit/{id}', 'editblogCategory')->name('edit.blogCategory');
    Route::post('/blogCategory/update/{id}', 'updateBlogCategory')->name('update.blogCategory');
    Route::get('/blogCategory/delete/{id}', 'deleteBlogCategory')->name('delete.blogCategory');
    //  Route::get('/portfolio/details/{id}', 'detailsPortfolio')->name('portfolio.details');

});




//Blog  page all routes
Route::controller(BlogController::class)->group(function () {
    Route::get('/blog/all/page', 'blogPages')->name('blog_all.page');
    Route::get('/blog/page', 'Addblog')->name('blog.page');
    Route::post('/blog/store', 'storeBlog')->name('store.blog');
    Route::get('/blog/edit/{id}', 'editBlog')->name('edit.blog');
    Route::post('/blog/update', 'updateBlog')->name('update.blog');
    Route::get('/blog/delete/{id}', 'deleteBlog')->name('delete.blog');
    Route::get('/blog/details/{id}', 'BlogDetails')->name('blog.details');
    Route::get('/category/blog/{id}', 'CategoryBlog')->name('category.blog');
    Route::get('/blog', 'Homeblog')->name('home.blog');
});

//Footer Page route
Route::controller(FooterController::class)->group(function () {
    Route::get('/footer/page', 'footerPage')->name('footer.page');
    Route::post('/footer/about', 'updateFooter')->name('update.footer');

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
