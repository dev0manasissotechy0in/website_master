<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\Yb_AdminController;  
use App\Http\Controllers\admin\Yb_BlogCategoryController;  
use App\Http\Controllers\admin\Yb_BlogController;  
use App\Http\Controllers\admin\Yb_ProductCategoryController;  
use App\Http\Controllers\admin\Yb_ProductSubCategoryController;  
use App\Http\Controllers\admin\Yb_ProductTagsController;  
use App\Http\Controllers\admin\Yb_ProductsController;  
use App\Http\Controllers\admin\Yb_SettingsController;  
use App\Http\Controllers\admin\Yb_PagesController;  
use App\Http\Controllers\admin\Yb_SocialLinksController;  
use App\Http\Controllers\admin\Yb_TestimonialsController;  
use App\Http\Controllers\admin\Yb_NewsletterController;  
use App\Http\Controllers\admin\Yb_OrderController;  
use App\Http\Controllers\admin\Yb_WithdrawMethodController;  
use App\Http\Controllers\admin\Yb_WithdrawRequestController;  
use App\Http\Controllers\admin\Yb_UserController as UsersList;  
use App\Http\Controllers\Yb_HomeController;  
use App\Http\Controllers\Yb_UserController;  
use App\Http\Controllers\Yb_ProductController;  
use App\Http\Controllers\Yb_PaymentController;  

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::group(['middleware'=>'installed'], function(){
    Route::group(['middleware'=>'protectedPage'],function(){
        Route::any('admin', [Yb_AdminController::class,'yb_index']);
        Route::get('admin/logout', [Yb_AdminController::class,'yb_logout']);
        Route::any('admin/edit-profile', [Yb_AdminController::class,'yb_edit_profile']);
        Route::post('admin/update-password', [Yb_AdminController::class,'yb_update_password']);
        Route::get('admin/dashboard', [Yb_AdminController::class,'yb_dashboard']);
        Route::resource('admin/blog-category', Yb_BlogCategoryController::class);
        Route::resource('admin/blogs', Yb_BlogController::class);
        Route::resource('admin/product-category', Yb_ProductCategoryController::class);
        Route::resource('admin/product-sub-category', Yb_ProductSubCategoryController::class);
        Route::resource('admin/product-tags', Yb_ProductTagsController::class);
        Route::any('admin/author-products', [Yb_ProductsController::class,'yb_author_products']);
        Route::post('admin/get-category-sub-categories', [Yb_ProductsController::class,'yb_get_category_sub_categories']);
        Route::resource('admin/products', Yb_ProductsController::class);
        Route::post('admin/page_showIn_header', [Yb_PagesController::class,'yb_pageShow_inHeaderStatus']);
        Route::post('admin/page_showIn_footer', [Yb_PagesController::class,'yb_pageShow_inFooterStatus']);
        Route::resource('admin/pages', Yb_PagesController::class);
        Route::resource('admin/social-links', Yb_SocialLinksController::class);
        Route::resource('admin/testimonials', Yb_TestimonialsController::class);
        Route::any('admin/orders', [Yb_OrderController::class,'index']);
        Route::get('admin/orders/{id}', [Yb_OrderController::class,'view']);
        Route::any('admin/sellers', [UsersList::class,'yb_sellers']);
        Route::any('admin/users/block', [UsersList::class,'yb_changeUser_status']);
        Route::any('admin/seller/approve', [UsersList::class,'yb_approveSeller']);
        Route::resource('admin/users', UsersList::class);
        Route::resource('admin/withdraw-methods', Yb_WithdrawMethodController::class);
        Route::post('admin/withdraw-requests/{id}/status', [Yb_WithdrawRequestController::class,'yb_changeStatus']);
        Route::resource('admin/withdraw-requests', Yb_WithdrawRequestController::class);
        Route::resource('admin/newsletter-subscribers', Yb_NewsletterController::class);
        Route::any('admin/product-reviews', [Yb_ProductsController::class,'yb_product_reviews']);
        Route::any('admin/product-reviews/{id}/edit', [Yb_ProductsController::class,'yb_edit_product_review']);
        Route::any('admin/product-reviews/{id}', [Yb_ProductsController::class,'yb_delete_review']);
        Route::any('admin/general-settings', [Yb_SettingsController::class,'yb_general_settings']);
        Route::any('admin/payment-settings', [Yb_SettingsController::class,'yb_payment_settings']);
        Route::any('admin/homepage-settings', [Yb_SettingsController::class,'yb_homepage_settings']);
        Route::any('admin/payment-gateways', [Yb_SettingsController::class,'yb_payment_gateways']);
        Route::get('admin/payment-gateways/{id}/edit', [Yb_SettingsController::class,'yb_update_payment_gateways']);
        Route::post('admin/payment-gateways/{id}', [Yb_SettingsController::class,'yb_update_payment_gateways']);
        Route::any('admin/banner', [Yb_SettingsController::class,'yb_banner']);
    });

    Route::get('/', [Yb_HomeController::class,'yb_index']);
    Route::any('login', [Yb_UserController::class,'yb_index']);
    Route::get('logout', [Yb_UserController::class,'yb_logout']);
    Route::get('signup', [Yb_UserController::class,'yb_create']);
    Route::get('seller-signup', [Yb_UserController::class,'yb_create_seller']);
    Route::post('signup', [Yb_UserController::class,'yb_store']);
    Route::any('signup/verification/{text}', [Yb_UserController::class,'yb_signup_verify']);
    Route::get('user-profile', [Yb_UserController::class,'yb_profile']);
    Route::any('user/edit-profile', [Yb_UserController::class,'yb_edit_profile']);
    Route::any('change-password', [Yb_UserController::class,'yb_change_password']);
    Route::get('my-products', [Yb_UserController::class,'yb_user_products']);
    Route::get('all-products', [Yb_HomeController::class,'yb_all_products']);
    Route::get('product/c/{text}', [Yb_HomeController::class,'yb_category_products']);
    Route::get('product/c/{text}/{slug}', [Yb_HomeController::class,'yb_subcategory_products']);
    Route::get('blogs', [Yb_HomeController::class,'yb_blogs']);
    Route::get('blogs/c/{text}', [Yb_HomeController::class,'yb_category_blogs']);
    Route::get('blog/{slug}', [Yb_HomeController::class,'yb_single_blog']);
    Route::any('forgot-password', [Yb_UserController::class,'yb_forgot_password']);
    Route::get('reset-password/{token}', [Yb_UserController::class,'yb_reset_password']);
    Route::post('update-user-password', [Yb_UserController::class,'yb_update_user_password']);
    Route::get('create-product', [Yb_ProductController::class,'yb_create']);
    Route::post('submit-product', [Yb_ProductController::class,'yb_store']);
    Route::get('seller/{text}/edit-product', [Yb_ProductController::class,'yb_edit']);
    Route::post('seller/{text}/update', [Yb_ProductController::class,'yb_update']);
    Route::get('seller/{text}', [Yb_HomeController::class,'yb_seller_products']);
    Route::get('product/{text}/download', [Yb_UserController::class,'yb_product_download']);
    Route::any('product/{text}/reviews', [Yb_UserController::class,'yb_product_reviews']);
    Route::get('product/{text}', [Yb_HomeController::class,'yb_single_product']);
    Route::post('user/add-wishlist', [Yb_UserController::class,'yb_add_wishlist']);
    Route::post('user/remove-wishlist', [Yb_UserController::class,'yb_remove_wishlist']);
    Route::get('my-wishlist', [Yb_UserController::class,'yb_user_wishlist']);
    Route::get('my-cart', [Yb_UserController::class,'yb_user_cart']);
    Route::get('my-downloads', [Yb_UserController::class,'yb_user_downloads']);
    Route::post('user/add-cart', [Yb_UserController::class,'yb_add_cart']);
    Route::post('user/remove-cart', [Yb_UserController::class,'yb_remove_cart']);
    Route::get('user/checkout', [Yb_UserController::class,'yb_checkout']);

    // Route::get('/success',[PaymentController::class,'success']);
    Route::get('pay-with-paypal',[Yb_PaymentController::class,'yb_create']);
    Route::get('/paypal/status',[Yb_PaymentController::class,'yb_paymentStatus'])->name('paypal-status');
    Route::get('/pay-with-razorpay',[Yb_PaymentController::class,'yb_create']);

    Route::get('/checkout/payment/success',[Yb_PaymentController::class,'yb_paymentSuccess']);   
    Route::get('/checkout/payment/failed',[Yb_PaymentController::class,'yb_paymentFailed']);   
    Route::post('submit-email',[Yb_HomeController::class,'yb_subscribe_email']);   
    Route::get('subscribe-verify/{token}',[Yb_HomeController::class,'yb_subscribe_email_verify']);   
    Route::get('product/tag/{text}',[Yb_HomeController::class,'yb_tag_products']);   
    Route::get('search',[Yb_HomeController::class,'yb_all_products']);   
    Route::post('get-search-autocomplete',[Yb_HomeController::class,'yb_get_search_autocomplete']);   
    Route::get('withdraw-requests',[Yb_UserController::class,'yb_withdraw_requests']);   
    Route::get('withdraw-requests/new',[Yb_UserController::class,'yb_new_withdraw_request']);   
    Route::post('withdraw-requests/submit',[Yb_UserController::class,'yb_submit_withdraw_request']);   
    Route::get('seller-wallet',[Yb_UserController::class,'yb_seller_wallet']);   

    Route::get('{text}', [Yb_HomeController::class,'yb_custom_page']);
});
