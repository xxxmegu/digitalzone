<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\GlavController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CategoryController;

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
    return view('welcome');
});
Route::get('/', [GlavController::class, 'index'])->name('glav');
Route::get('/glav', [GlavController::class, 'index']);
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/catalog', [CatalogController::class, 'getProducts'])->name('catalog');
Route::get('/products', [ProductController::class, 'getProducts'])->name('products');
Route::get('/product/{id}', [ProductController::class, 'index'])->name('product');
Route::get('/where', function () {
    return view('where');
})->name('where');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/user', [ProfileController::class, 'index'])->name('user');
    Route::get('/change-password', [ProfileController::class, 'showChangePasswordForm'])->name('password.change');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::get('/add-to-cart/{id}', [CartController::class, 'addToCart']);
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::get('/changeqty/{param}/{id}', [CartController::class, 'changeQty']);
    Route::get('/create-order', [OrderController::class, 'index'])->name('create-order');
    Route::post('/create-order', [OrderController::class, 'createOrder']);
    Route::delete('/order-delete/{number}', [OrderController::class, 'deleteOrder']);
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggle']);
    Route::post('/favorites/check', [FavoriteController::class, 'check']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::post('/cart/update', [CartController::class, 'update']);
    Route::post('/cart/remove', [CartController::class, 'remove']);
    Route::post('/cart/clear', [CartController::class, 'clear']);
    Route::post('/profile/update-phone', [ProfileController::class, 'updatePhone'])->name('profile.update-phone');
    Route::get('/cart/count', function () {
        return response()->json(['count' => session('cart') ? count(session('cart')) : 0]);
    });
});

Route::middleware(['auth', 'is-admin'])->group(function () {
    Route::get('/product-create', [ProductController::class, 'createProductView']);
    Route::patch('/product-create', [ProductController::class, 'createProduct']);
    Route::get('/products', [ProductController::class, 'getProducts'])->name('admin.products');
    Route::get('/product-edit/{id}', [ProductController::class, 'getProductById']);
    Route::patch('/product-update/{id}', [ProductController::class, 'editProduct']);
    Route::delete('/product-delete/{id}', [ProductController::class, 'deleteProduct']);

    Route::get('/category-create', [CategoriesController::class, 'createCategoryView'])->name('category.create');
    Route::post('/category-create', [CategoriesController::class, 'createCategory']);
    Route::post('/subcategory-create', [CategoriesController::class, 'createSubcategory']);
    Route::get('/categories', [CategoriesController::class, 'getCategories'])->name('admin.categories');
    Route::get('/category-edit/{id}', [CategoriesController::class, 'editCategoryView']);
    Route::patch('/category-update/{id}', [CategoriesController::class, 'updateCategory']);
    Route::delete('/category-delete/{id}', [CategoriesController::class, 'deleteCategory']);
    Route::delete('/subcategory-delete/{id}', [CategoriesController::class, 'deleteSubcategory']);
    Route::get('/subcategory-edit/{id}', [CategoriesController::class, 'editSubcategoryView']);
    Route::patch('/subcategory-update/{id}', [CategoriesController::class, 'updateSubcategory']);

    Route::get('/orders', [OrderController::class, 'getOrders'])->name('admin.orders');
    Route::patch('/order-status/{action}/{number}', [OrderController::class, 'editOrderStatus']);
});

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

require __DIR__ . '/auth.php';
