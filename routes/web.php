<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Front Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', [GuestController::class, "index"])->name('guest.index');
Route::get('shop', [ShopController::class, "index"])->name('guest.shop');
Route::get('shop/category/{category_slug}', [ShopController::class, "productByCategory"])->name('shop.category');

Route::get('product/{productDetail}', [GuestController::class, "productDetail"])
	->name('guest.productDetail');

Route::post('cart/empty', [CartController::class, "cartEmpty"])->name('cart.empty');

//CART Functionality
Route::post('cart/product/{productSlug}', [CartController::class, "addCart"])->name('product.addCart');
Route::get('cart', [CartController::class, "index"])->name('guest.cart');

Route::get('checkout/address', [ShippingController::class, "Address"])->name('guest.checkout.address');
Route::post('checkout/address', [ShippingController::class, "AddressPost"])->name('guest.checkout.addressPost');

Route::get('checkout/shipping', [ShippingController::class, "Shipping"])->name('guest.checkout.shipping');
Route::post('checkout/shipping', [ShippingController::class, "ShippingPost"])->name('guest.checkout.shippingPost');

Route::get('checkout/payment', [PaymentController::class, "index"])->name('guest.checkout.payment');
Route::post('checkout/payment', [PaymentController::class, "indexPost"])->name('guest.checkout.paymentPost');

Route::get('checkout/complete', [PaymentController::class, "Complete"])->name('guest.checkout.complete');

Route::view('blog', 'guest.blog')->name('guest.blog');
Route::view('blog/post', 'guest.blog-post')->name('guest.blog-post');

// STATIC PAGES
Route::view('privacy-policy', 'guest.privacy-policy')->name('guest.privacy-policy');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
*/

Route::prefix('admin')->middleware('verified', 'auth', 'role:admin')->group(function()
{
		Route::view('dashboard', 'admin.dashboard')->name('admin.dashboard');

		Route::view('orders', 'admin.orders')->name('admin.orders');
		Route::view('order/{order_id}', 'admin.orderDetail')->name('order.detail');
		
		Route::resource('inventory/categories', CategoryController::class);
		Route::resource('inventory/products', ProductController::class);
		Route::resource('inventory/products/image', ProductImageController::class);
		Route::resource('users', UserController::class);

});





/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
|
*/

Route::prefix('account')->middleware('verified', 'auth', 'role:customer')->group(function()
{

	   Route::view('orders', 'members.orders')->name('members.orders');
	   Route::view('profile', 'members.profile')->name('members.profile');
	   Route::view('addresses', 'members.addresses')->name('members.addresses');
	   Route::view('wishlist', 'members.wishlist')->name('members.wishlist');

});

require __DIR__.'/auth.php';
