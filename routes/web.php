<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\AuthController;
use App\Http\Controllers\frontend\HomeController as TrangChuController;
use App\Http\Controllers\frontend\ProductController as SanPhamController;
use App\Http\Controllers\frontend\ContactController as LienHeController;
use App\Http\Controllers\frontend\PostController as BaiVietController;

use App\Http\Controllers\backend\BrandController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\BannerController;
use App\Http\Controllers\backend\ContactController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\TopicController;
use App\Http\Controllers\backend\PostController;
use App\Http\Controllers\backend\OrderController;
use App\Http\Controllers\backend\MenuController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\ThanhVienController;

Route::get('/', [TrangChuController::class, 'index'])->name('site.home');
Route::get('/trang-chu', [TrangChuController::class, 'index'])->name('site.home');
Route::get('/trang-chu/san-pham', [SanPhamController::class, 'index'])->name('site.product');
Route::get('/trang-chu/san-pham/{slug}', [SanPhamController::class, 'detail'])->name('site.product.detail');
Route::get('/products/search', [SanPhamController::class, 'searchNameProduct']);
Route::get('/products/results', [SanPhamController::class, 'showSearchResults'])->name('site.searchResults');

Route::get('/trang-chu/lien-he', [LienHeController::class, 'contact'])->name('site.contact');
Route::post('/trang-chu/lien-he', [LienHeController::class, 'sendcontact'])->name('site.contact.send');
Route::get('/trang-chu/bai-viet', [BaiVietController::class, 'index'])->name('site.post');
Route::get('/trang-chu/bai-viet/chu-de/{slug}', [BaiVietController::class, 'index'])->name('site.post.slug');
Route::get('/trang-chu/bai-viet/{slug}', [BaiVietController::class, 'detail'])->name('site.post.detail');

Route::get('/dang-nhap', [ThanhVienController::class, 'login'])->name('site.login');
Route::post('/dang-nhap', [ThanhVienController::class, 'dologin'])->name('site.dologin');
Route::get('/dang-ky', [ThanhVienController::class, 'register'])->name('site.register');
Route::post('/dang-ky', [ThanhVienController::class, 'doregister'])->name('site.doregister');
Route::post('/dang-xuat', [ThanhVienController::class, 'logout'])->name('site.logout');
Route::get('/thong-tin', [ThanhVienController::class, 'profile'])->name('site.profile');
Route::get('/chinh-sua-thong-tin', [ThanhVienController::class, 'editprofile'])->name('site.editprofile');
Route::get('/thong-tin-don-hang', [ThanhVienController::class, 'order'])->name('site.order');
Route::get('/chi-tiet-don-hang/{id}', [ThanhVienController::class, 'orderdetail'])->name('site.orderdetail');
Route::post('/chinh-sua-thong-tin/{userId}', [ThanhVienController::class, 'doeditprofile'])->name('profile.update');

Route::get('/add-to-cart/{id}', [CartController::class, 'addcart'])->name('site.addcart');
Route::post('/updatecart', [CartController::class, 'updatecart'])->name('site.updatecart');
Route::get('/delcart/{id?}', [CartController::class, 'delcart'])->name('site.delcart');
Route::get('/gio-hang', [CartController::class, 'index'])->name('site.cart');
Route::post('/thanh-toan', [CartController::class, 'checkout'])->name('site.checkout');
Route::get('/cam-on', [CartController::class, 'thanks'])->name('site.thanks');

Route::get('/admin/login', [AuthController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'dologin'])->name('admin.dologin');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');
Route::get('/admin/forgotpassword', [AuthController::class, 'doforgotpassword'])->name('admin.doforgotpassword');
Route::post('/admin/forgotpassword', [AuthController::class, 'forgotpassword'])->name('admin.forgotpassword');
Route::post('/admin/updatepassword', [AuthController::class, 'updatepassword'])->name('admin.updatepassword');



Route::prefix('admin')->middleware('login-admin')->group(function () {

    //dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Product
    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('admin.product.index');
        Route::get('create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::post('store', [ProductController::class, 'store'])->name('admin.product.store');
        Route::get('{product}/{id}/show', [ProductController::class, 'show'])->name('admin.product.show');
        Route::get('{product}/{id}/edit', [ProductController::class, 'edit'])->name('admin.product.edit');
        Route::put('{id}/update', [ProductController::class, 'update'])->name('admin.product.update');
        Route::get('{product}/{id}/status', [ProductController::class, 'status'])->name('admin.product.status');
        Route::get('{id}/delete', [ProductController::class, 'delete'])->name('admin.product.delete');
        Route::get('{id}/restore', [ProductController::class, 'restore'])->name('admin.product.restore');
        Route::get('trash', [ProductController::class, 'trash'])->name('admin.product.trash');
        Route::delete('{product}/{id}', [ProductController::class, 'destroy'])->name('admin.product.destroy');
    });
    Route::resource('product', ProductController::class);

    // Banner
    Route::prefix('banner')->group(function () {
        Route::get('/', [BannerController::class, 'index'])->name('admin.banner.index');
        Route::get('create', [BannerController::class, 'create'])->name('admin.banner.create');
        Route::post('store', [BannerController::class, 'store'])->name('admin.banner.store');
        Route::get('{banner}/{id}/show', [BannerController::class, 'show'])->name('admin.banner.show');
        Route::get('{banner}/{id}/edit', [BannerController::class, 'edit'])->name('admin.banner.edit');
        Route::put('{banner}/{id}/update', [BannerController::class, 'update'])->name('admin.banner.update');
        Route::get('{banner}/{id}/status', [BannerController::class, 'status'])->name('admin.banner.status');
        Route::get('{id}/delete', [BannerController::class, 'delete'])->name('admin.banner.delete');
        Route::get('{id}/restore', [BannerController::class, 'restore'])->name('admin.banner.restore');
        Route::get('trash', [BannerController::class, 'trash'])->name('admin.banner.trash');
        Route::delete('{banner}/{id}/destroy', [BannerController::class, 'destroy'])->name('admin.banner.destroy');
    });
    Route::resource('banner', BannerController::class);

    // Brand
    Route::prefix('brand')->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('admin.brand.index');
        Route::get('create', [BrandController::class, 'create'])->name('admin.brand.create');
        Route::post('store', [BrandController::class, 'store'])->name('admin.brand.store');
        Route::get('{brand}/{id}/show', [BrandController::class, 'show'])->name('admin.brand.show');
        Route::get('{brand}/{id}/edit', [BrandController::class, 'edit'])->name('admin.brand.edit');
        Route::put('{brand}/{id}/update', [BrandController::class, 'update'])->name('admin.brand.update');
        Route::get('{brand}/{id}/status', [BrandController::class, 'status'])->name('admin.brand.status');
        Route::get('{id}/delete', [BrandController::class, 'delete'])->name('admin.brand.delete');
        Route::get('{id}/restore', [BrandController::class, 'restore'])->name('admin.brand.restore');
        Route::get('trash', [BrandController::class, 'trash'])->name('admin.brand.trash');
        Route::delete('{brand}/{id}/destroy', [BrandController::class, 'destroy'])->name('admin.brand.destroy');
    });
    Route::resource('brand', BrandController::class);

    // Category
    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('admin.category.index');
        Route::get('create', [CategoryController::class, 'create'])->name('admin.category.create');
        Route::post('store', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::get('{category}/{id}/show', [CategoryController::class, 'show'])->name('admin.category.show');
        Route::get('{category}/{id}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::put('{category}/{id}/update', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::get('{category}/{id}/status', [CategoryController::class, 'status'])->name('admin.category.status');
        Route::get('{id}/delete', [CategoryController::class, 'delete'])->name('admin.category.delete');
        Route::get('{id}/restore', [CategoryController::class, 'restore'])->name('admin.category.restore');
        Route::get('trash', [CategoryController::class, 'trash'])->name('admin.category.trash');
        Route::delete('{category}/{id}/destroy', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
    });
    Route::resource('category', CategoryController::class);

    // Contact
    Route::prefix('contact')->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('admin.contact.index');
        Route::get('contact/{contact_id}/reply', [ContactController::class, 'reply'])->name('admin.contact.reply');
        Route::post('contact/{contact_id}/reply', [ContactController::class, 'storeReply'])->name('admin.contact.reply.store');
        Route::get('{contact}/{id}/show', [ContactController::class, 'show'])->name('admin.contact.show');
        Route::get('{contact}/{id}/status', [ContactController::class, 'status'])->name('admin.contact.status');
        Route::get('{id}/delete', [ContactController::class, 'delete'])->name('admin.contact.delete');
        Route::get('{id}/restore', [ContactController::class, 'restore'])->name('admin.contact.restore');
        Route::get('trash', [ContactController::class, 'trash'])->name('admin.contact.trash');
        Route::delete('{contact}/{id}/destroy', [ContactController::class, 'destroy'])->name('admin.contact.destroy');
    });


    Route::resource('contact', ContactController::class);

    // User
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.user.index');
        Route::get('create', [UserController::class, 'create'])->name('admin.user.create');
        Route::post('store', [UserController::class, 'store'])->name('admin.user.store');
        Route::get('{user}/{id}/show', [UserController::class, 'show'])->name('admin.user.show');
        Route::get('{user}/{id}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
        Route::put('{user}/{id}/update', [UserController::class, 'update'])->name('admin.user.update');
        Route::get('{user}/{id}/status', [UserController::class, 'status'])->name('admin.user.status');
        Route::get('{id}/delete', [UserController::class, 'delete'])->name('admin.user.delete');
        Route::get('{id}/restore', [UserController::class, 'restore'])->name('admin.user.restore');
        Route::get('trash', [UserController::class, 'trash'])->name('admin.user.trash');
        Route::delete('{user}/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');
    });
    Route::resource('user', UserController::class);

    // Topic
    Route::prefix('topic')->group(function () {
        Route::get('/', [TopicController::class, 'index'])->name('admin.topic.index');
        Route::get('create', [TopicController::class, 'create'])->name('admin.topic.create');
        Route::post('store', [TopicController::class, 'store'])->name('admin.topic.store');
        Route::get('{topic}/{id}/show', [TopicController::class, 'show'])->name('admin.topic.show');
        Route::get('{topic}/{id}/edit', [TopicController::class, 'edit'])->name('admin.topic.edit');
        Route::put('{id}/update', [TopicController::class, 'update'])->name('admin.topic.update');
        Route::get('{topic}/{id}/status', [TopicController::class, 'status'])->name('admin.topic.status');
        Route::get('{id}/delete', [TopicController::class, 'delete'])->name('admin.topic.delete');
        Route::get('{id}/restore', [TopicController::class, 'restore'])->name('admin.topic.restore');
        Route::get('trash', [TopicController::class, 'trash'])->name('admin.topic.trash');
        Route::delete('{topic}/{id}', [TopicController::class, 'destroy'])->name('admin.topic.destroy');
    });
    Route::resource('topic', TopicController::class);

    // Post
    Route::prefix('post')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('admin.post.index');
        Route::get('create', [PostController::class, 'create'])->name('admin.post.create');
        Route::post('store', [PostController::class, 'store'])->name('admin.post.store');
        Route::get('{post}/{id}/show', [PostController::class, 'show'])->name('admin.post.show');
        Route::get('{post}/{id}/edit', [PostController::class, 'edit'])->name('admin.post.edit');
        Route::put('{id}/update', [PostController::class, 'update'])->name('admin.post.update');
        Route::get('{post}/{id}/status', [PostController::class, 'status'])->name('admin.post.status');
        Route::get('{id}/delete', [PostController::class, 'delete'])->name('admin.post.delete');
        Route::get('{id}/restore', [PostController::class, 'restore'])->name('admin.post.restore');
        Route::get('trash', [PostController::class, 'trash'])->name('admin.post.trash');
        Route::delete('{post}/{id}', [PostController::class, 'destroy'])->name('admin.post.destroy');
    });
    Route::resource('post', PostController::class);

    // Menu
    Route::prefix('menu')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('admin.menu.index');
        Route::get('create', [MenuController::class, 'create'])->name('admin.menu.create');
        Route::post('store', [MenuController::class, 'store'])->name('admin.menu.store');
        Route::get('{menu}/{id}/show', [MenuController::class, 'show'])->name('admin.menu.show');
        Route::get('{menu}/{id}/edit', [MenuController::class, 'edit'])->name('admin.menu.edit');
        Route::put('{id}/update', [MenuController::class, 'update'])->name('admin.menu.update');
        Route::get('{menu}/{id}/status', [MenuController::class, 'status'])->name('admin.menu.status');
        Route::get('{id}/delete', [MenuController::class, 'delete'])->name('admin.menu.delete');
        Route::get('{id}/restore', [MenuController::class, 'restore'])->name('admin.menu.restore');
        Route::get('trash', [MenuController::class, 'trash'])->name('admin.menu.trash');
        Route::delete('{menu}/{id}', [MenuController::class, 'destroy'])->name('admin.menu.destroy');
    });
    Route::resource('menu', MenuController::class);


    // Order
    Route::prefix('order')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('admin.order.index');
        Route::get('{order}/{id}', [OrderController::class, 'show'])->name('admin.order.show');
        Route::get('{order}/{id}/status', [OrderController::class, 'status'])->name('admin.order.status');
        Route::get('{id}/delete', [OrderController::class, 'delete'])->name('admin.order.delete');
        Route::get('{id}/restore', [OrderController::class, 'restore'])->name('admin.order.restore');
        Route::get('trash', [OrderController::class, 'trash'])->name('admin.order.trash');
        Route::delete('{order}/{id}', [OrderController::class, 'destroy'])->name('admin.order.destroy');
    });
    Route::resource('order', OrderController::class);
});
