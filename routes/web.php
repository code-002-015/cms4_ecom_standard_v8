<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\TemplateCategoryController;
use App\Http\Controllers\TemplateController;



// CMS4 Controllers
use App\Http\Controllers\Cms4Controllers\ArticleCategoryController;
use App\Http\Controllers\Cms4Controllers\ArticleFrontController;
use App\Http\Controllers\Cms4Controllers\ArticleController;
use App\Http\Controllers\Cms4Controllers\AlbumController;
use App\Http\Controllers\Cms4Controllers\PageController;
use App\Http\Controllers\Cms4Controllers\MenuController;
use App\Http\Controllers\Settings\PermissionController;
use App\Http\Controllers\Settings\AccountController;
use App\Http\Controllers\Settings\AccessController;
use App\Http\Controllers\Settings\UserController;
use App\Http\Controllers\Settings\LogsController;
use App\Http\Controllers\Settings\RoleController;
use App\Http\Controllers\Settings\WebController;
use App\Http\Controllers\Cms4Controllers\FileManagerController;


use App\Http\Controllers\FrontController;
use \UniSharp\LaravelFilemanager\Controllers\LfmController;
//


// Ecommerce Controllers
use App\Http\Controllers\EcommerceControllers\Product\Front\ProductFrontController;
use App\Http\Controllers\EcommerceControllers\Product\ProductCategoryController;
use App\Http\Controllers\EcommerceControllers\Product\ProductController;
use App\Http\Controllers\EcommerceControllers\InventoryReceiverHeaderController;
use App\Http\Controllers\EcommerceControllers\DeliverablecitiesController;
use App\Http\Controllers\EcommerceControllers\PromoController;

use App\Http\Controllers\EcommerceControllers\FavoriteController;
use App\Http\Controllers\EcommerceControllers\WishlistController;

use App\Http\Controllers\EcommerceControllers\CheckoutController;
use App\Http\Controllers\EcommerceControllers\ReportsController;
use App\Http\Controllers\EcommerceControllers\SalesController;
use App\Http\Controllers\EcommerceControllers\CartController;
use App\Http\Controllers\EcommerceControllers\ShopController;
use App\Http\Controllers\EcommerceControllers\MyAccountController;

use App\Http\Controllers\EcommerceControllers\CouponController;


use App\Http\Controllers\EcommerceControllers\CustomerFrontController;
use App\Http\Controllers\EcommerceControllers\SalesFrontController;

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

// Route::get('/', function () {
//     return redirect(route('home'));
// });




Route::get('/templates-list',[FrontController::class, 'registration'])->name('template.registration');
Route::get('/request-demo/{id}',[FrontController::class, 'request_for_demo'])->name('template.request_demo');




 Route::get('/', function () {
     return redirect(route('shop'));
 });


// CMS4 Front Pages
    Route::get('/', [FrontController::class, 'home'])->name('home');
    Route::get('/privacy-policy/', [FrontController::class, 'privacy_policy'])->name('privacy-policy');
    Route::post('/contact-us', [FrontController::class, 'contact_us'])->name('contact-us');

    Route::post('/contact-us-ajax', [FrontController::class, 'contact_us_ajax'])->name('contact-us-ajax');
    Route::get('/search', [FrontController::class, 'search'])->name('search');

    //News Frontend
        Route::get('/news/', [ArticleFrontController::class, 'news_list'])->name('news.front.index');
        Route::get('/news/{slug}', [ArticleFrontController::class, 'news_view'])->name('news.front.show');
        Route::get('/news/{slug}/print', [ArticleFrontController::class, 'news_print'])->name('news.front.print');
        Route::post('/news/{slug}/share', [ArticleFrontController::class, 'news_share'])->name('news.front.share');

        Route::get('/albums/preview', [FrontController::class, 'test'])->name('albums.preview');
        Route::get('/search-result', [FrontController::class, 'seach_result'])->name('search.result');
    //
//






// Ecommerce Pages
    Route::get('/login', [CustomerFrontController::class, 'login'])->name('customer-front.login');
    Route::get('/account-logout', [LoginController::class, 'logout'])->name('account.logout');

    Route::post('/customer-sign-up', [CustomerFrontController::class, 'customer_sign_up'])->name('customer-front.customer-sign-up');
    Route::post('/login', [CustomerFrontController::class, 'customer_login'])->name('customer-front.customer_login');

    Route::get('/forgot-password', 'EcommerceControllers\EcommerceFrontController@forgot_password')->name('ecommerce.forgot_password');
    Route::post('/forgot-password', 'EcommerceControllers\EcommerceFrontController@sendResetLinkEmail')->name('ecommerce.send_reset_link_email');
    Route::get('/reset-password/{token}', 'EcommerceControllers\EcommerceFrontController@showResetForm')->name('ecommerce.reset_password');
    Route::post('/reset-password', 'EcommerceControllers\EcommerceFrontController@reset')->name('ecommerce.reset_password_post');


    Route::get('/shop', [ShopController::class, 'index'])->name('shop');


    Route::get('/products/{slug}', [ProductFrontController::class, 'show'])->name('product.front.show');








    // Cart
        Route::get('/cart', [CartController::class, 'cart'])->name('cart.front.show');
        Route::post('cart-add-product',[CartController::class, 'add_to_cart'])->name('cart.add');
        Route::post('cart-remove-product', [CartController::class, 'remove_product'])->name('cart.remove_product');
        Route::post('cart-update', [CartController::class, 'cart_update'])->name('cart.update');


        Route::post('cart/deduct-qty','EcommerceControllers\CartController@deduct_qty')->name('cart.deduct');

        Route::post('cart/proceed-checkout','EcommerceControllers\CartController@proceed_checkout')->name('cart.front.proceed_checkout');

    //
//



// CUSTOMER ROUTES
Route::group(['middleware' => ['authenticated']], function () {
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.front.checkout');
//    Route::post('/temp_save',[CartController::class, 'save_sales'])->name('cart.temp_sales');
//    Route::post('product/review/store', [ProductReviewController::class, 'store'])->name('product.review.store');
//    Route::get('/checkout', 'EcommerceControllers\CheckoutController@checkout')->name('cart.front.checkout');
    Route::post('/temp_save',[CartController::class, 'save_sales'])->name('cart.temp_sales');
    Route::get('/account/sales', [SalesFrontController::class, 'sales_list'])->name('profile.sales');
    Route::post('/account/product-reorder',[SalesFrontController::class, 'reorder'])->name('profile.sales-reorder-product');
    Route::post('/account/reorder', [SalesFrontController::class, 'reorder'])->name('my-account.reorder');
    Route::post('/account/cancel/order', [SalesFrontController::class, 'cancel_order'])->name('my-account.cancel-order');
    Route::get('/account/manage', [MyAccountController::class, 'manage_account'])->name('my-account.manage-account');
    Route::post('/account/manage', [MyAccountController::class, 'update_personal_info'])->name('my-account.update-personal-info');
    Route::post('/account/manage/update-contact', [MyAccountController::class, 'update_contact_info'])->name('my-account.update-contact-info');
    Route::post('/account/manage/update-address', [MyAccountController::class, 'update_address_info'])->name('my-account.update-address-info');

    Route::get('/account/change-password', [MyAccountController::class, 'change_password'])->name('my-account.change-password');

    Route::post('/account/change-password', [MyAccountController::class, 'update_password'])->name('my-account.update-password');

    Route::get('/account/pay/{id}', [CartController::class, 'pay_again'])->name('my-account.pay-again');

});



// ADMIN ROUTES
Route::group(['prefix' => env('APP_PANEL', 'cerebro')], function (){
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('panel.login');

    Auth::routes();

    Route::group(['middleware' => 'admin'], function (){

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/admin/ecommerce-dashboard', [DashboardController::class, 'ecommerce'])->name('ecom-dashboard');

        // Account
            Route::get('/account/edit', [AccountController::class, 'edit'])->name('account.edit');
            Route::put('/account/update', [AccountController::class, 'update'])->name('account.update');
            Route::put('/account/update_email', [AccountController::class, 'update_email'])->name('account.update-email');
            Route::put('/account/update_password', [AccountController::class, 'update_password'])->name('account.update-password');
        //

        // Website
            Route::get('/website-settings/edit', [WebController::class, 'edit'])->name('website-settings.edit');
            Route::put('/website-settings/update', [WebController::class, 'update'])->name('website-settings.update');
            Route::post('/website-settings/update_contacts', [WebController::class, 'update_contacts'])->name('website-settings.update-contacts');
            Route::post('/website-settings/update-ecommerce', [WebController::class, 'update_ecommerce'])->name('website-settings.update-ecommerce');
            Route::post('/website-settings/update-paynamics', [WebController::class, 'update_paynamics'])->name('website-settings.update-paynamics');
            Route::post('/website-settings/update_media_accounts', [WebController::class, 'update_media_accounts'])->name('website-settings.update-media-accounts');
            Route::post('/website-settings/update_data_privacy', [WebController::class, 'update_data_privacy'])->name('website-settings.update-data-privacy');
            Route::post('/website-settings/remove_logo', [WebController::class, 'remove_logo'])->name('website-settings.remove-logo');
            Route::post('/website-settings/remove_icon', [WebController::class, 'remove_icon'])->name('website-settings.remove-icon');
            Route::post('/website-settings/remove_media', [WebController::class, 'remove_media'])->name('website-settings.remove-media');
        //

        // Audit
            Route::get('/audit-logs', [LogsController::class, 'index'])->name('audit-logs.index');
        //

        // Users
            Route::resource('/users', UserController::class);
            Route::post('/users/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
            Route::post('/users/activate', [UserController::class, 'activate'])->name('users.activate');
            Route::get('/user-search/', [UserController::class, 'search'])->name('user.search');
            Route::get('/profile-log-search/', [UserController::class, 'filter'])->name('user.activity.search');
        //

        // Roles
            Route::resource('/role', RoleController::class);
            Route::post('/role/delete',[RoleController::class, 'destroy'])->name('role.delete');
            Route::get('/role/restore/{id}',[RoleController::class, 'restore'])->name('role.restore');
        //

        // Access
            Route::resource('/access', AccessController::class);
            Route::post('/roles_and_permissions/update', [AccessController::class, 'update_roles_and_permissions'])->name('role-permission.update');

            if (env('APP_DEBUG') == "true") {
                // Permission Routes
                Route::resource('/permission', PermissionController::class);
                Route::get('/permission-search/', [PermissionController::class, 'search'])->name('permission.search');
                Route::post('/permission/destroy', [PermissionController::class, 'destroy'])->name('permission.destroy');
                Route::get('/permission/restore/{id}', [PermissionController::class, 'restore'])->name('permission.restore');
            }
        //



        ###### CMS4 Standard Routes ######
            //Pages
                Route::resource('/pages', PageController::class);
                Route::get('/pages-advance-search', [PageController::class, 'advance_index'])->name('pages.index.advance-search');
                Route::post('/pages/get-slug', [PageController::class, 'get_slug'])->name('pages.get_slug');
                Route::put('/pages/{page}/default', [PageController::class, 'update_default'])->name('pages.update-default');
                Route::put('/pages/{page}/customize', [PageController::class, 'update_customize'])->name('pages.update-customize');
                Route::put('/pages/{page}/contact-us', [PageController::class, 'update_contact_us'])->name('pages.update-contact-us');
                Route::post('/pages-change-status', [PageController::class, 'change_status'])->name('pages.change.status');
                Route::post('/pages-delete', [PageController::class, 'delete'])->name('pages.delete');
                Route::get('/page-restore/{page}', [PageController::class, 'restore'])->name('pages.restore');
            //

            // Albums
                Route::resource('/albums', AlbumController::class);
                Route::post('/albums/upload', [AlbumController::class, 'upload'])->name('albums.upload');
                Route::delete('/many/album', [AlbumController::class, 'destroy_many'])->name('albums.destroy_many');
                Route::put('/albums/quick/{album}', [AlbumController::class, 'quick_update'])->name('albums.quick_update');
                Route::post('/albums/{album}/restore', [AlbumController::class, 'restore'])->name('albums.restore');
                Route::post('/albums/banners/{album}', [AlbumController::class, 'get_album_details'])->name('albums.banners');
            //

            // News
                Route::resource('/news', ArticleController::class)->except(['show', 'destroy']);
                Route::get('/news-advance-search', [ArticleController::class, 'advance_index'])->name('news.index.advance-search');
                Route::post('/news-get-slug', [ArticleController::class, 'get_slug'])->name('news.get-slug');
                Route::post('/news-change-status', [ArticleController::class, 'change_status'])->name('news.change.status');
                Route::post('/news-delete', [ArticleController::class, 'delete'])->name('news.delete');
                Route::get('/news-restore/{news}', [ArticleController::class, 'restore'])->name('news.restore');

                // News Category
                Route::resource('/news-categories', ArticleCategoryController::class)->except(['show']);;
                Route::post('/news-categories/get-slug', [ArticleCategoryController::class, 'get_slug'])->name('news-categories.get-slug');
                Route::post('/news-categories/delete', [ArticleCategoryController::class, 'delete'])->name('news-categories.delete');
                Route::get('/news-categories/restore/{id}', [ArticleCategoryController::class, 'restore'])->name('news-categories.restore');
            //

            // Files
                Route::get('/laravel-filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show')->name('file-manager.show');
                Route::post('/laravel-filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload')->name('file-manager.upload');
                Route::get('/file-manager', [FileManagerController::class, 'index'])->name('file-manager.index');
            //

            // Menu
                Route::resource('/menus', MenuController::class);
                Route::delete('/many/menu', [MenuController::class, 'destroy_many'])->name('menus.destroy_many');
                Route::put('/menus/quick1/{menu}', [MenuController::class, 'quick_update'])->name('menus.quick_update');
                Route::get('/menu-restore/{menu}', [MenuController::class, 'restore'])->name('menus.restore');
            //
        ###### CMS4 Standard Routes ######



        ###### Ecommerce Standard Routes ######
            // Product Categories
                Route::resource('/admin/product-categories',ProductCategoryController::class);
                Route::post('/admin/product-category-get-slug', [ProductCategoryController::class, 'get_slug'])->name('product.category.get-slug');
                Route::post('/admin/product-categories-single-delete', [ProductCategoryController::class, 'single_delete'])->name('product.category.single.delete');
                Route::get('/admin/product-category/search', [ProductCategoryController::class, 'search'])->name('product.category.search');
                Route::get('/admin/product-category/restore/{id}', [ProductCategoryController::class, 'restore'])->name('product.category.restore');
                Route::get('/admin/product-category/{id}/{status}', [ProductCategoryController::class, 'update_status'])->name('product.category.change-status');
                Route::post('/admin/product-categories-multiple-change-status',[ProductCategoryController::class, 'multiple_change_status'])->name('product.category.multiple.change.status');
                Route::post('/admin/product-category-multiple-delete',[ProductCategoryController::class, 'multiple_delete'])->name('product.category.multiple.delete');

                Route::get('/product-favorites/', 'EcommerceControllers\FavoriteController@index')->name('product-favorite.list');
                Route::get('/product-wishlist/', 'EcommerceControllers\WishlistController@index')->name('product-wishlist.list');
            //

            // Products
                Route::resource('/admin/products', ProductController::class);
                Route::get('/products-advance-search', 'Product\ProductController@advance_index')->name('product.index.advance-search');
                Route::post('/admin/product-get-slug', [ProductController::class, 'get_slug'])->name('product.get-slug');
                Route::post('/admin/products/upload', [ProductController::class, 'upload'])->name('products.upload');

                Route::get('/admin/product-change-status/{id}/{status}', [ProductController::class, 'change_status'])->name('product.single-change-status');
                Route::post('/admin/product-single-delete', [ProductController::class, 'single_delete'])->name('product.single.delete');
                Route::get('/admin/product/restore/{id}', [ProductController::class, 'restore'])->name('product.restore');
                Route::post('/admin/product-multiple-change-status', [ProductController::class, 'multiple_change_status'])->name('product.multiple.change.status');
                Route::post('/admin/product-multiple-delete', [ProductController::class, 'multiple_delete'])->name('products.multiple.delete');
            //

            // Product Favorite
                Route::get('/product-favorites/', [FavoriteController::class, 'index'])->name('product-favorite.list');
            // Product Wishlist
                Route::get('/product-wishlist/', [WishlistController::class, 'index'])->name('product-wishlist.list');
            //

            //Inventory
                Route::resource('/inventory',InventoryReceiverHeaderController::class);
                Route::get('/inventory-download-template',[InventoryReceiverHeaderController::class, 'download_template'])->name('inventory.download.template');
                Route::post('/inventory-upload-template',[InventoryReceiverHeaderController::class, 'upload_template'])->name('inventory.upload.template');
                Route::get('/inventory-post/{id}',[InventoryReceiverHeaderController::class, 'post'])->name('inventory.post');
                Route::get('/inventory-cancel/{id}',[InventoryReceiverHeaderController::class, 'cancel'])->name('inventory.cancel');
                Route::get('/inventory-view/{id}',[InventoryReceiverHeaderController::class, 'view'])->name('inventory.view');
            //

            // Promos
                Route::resource('/admin/promos', PromoController::class);
                Route::get('/admin/promo/{id}/{status}', [PromoController::class, 'update_status'])->name('promo.change-status');
                Route::post('/admin/promo-single-delete', [PromoController::class, 'single_delete'])->name('promo.single.delete');
                Route::post('/admin/promo-multiple-change-status',[PromoController::class, 'multiple_change_status'])->name('promo.multiple.change.status');
                Route::post('/admin/promo-multiple-delete',[PromoController::class, 'multiple_delete'])->name('promo.multiple.delete');
                Route::get('/admin/promo-restore/{id}', [PromoController::class, 'restore'])->name('promo.restore');
            //

            // Delivery Rates
                Route::resource('/locations', DeliverablecitiesController::class);
                Route::get('/admin/location/{id}/{status}', [DeliverablecitiesController::class, 'update_status'])->name('location.change-status');
                Route::post('/admin/location-single-delete', [DeliverablecitiesController::class, 'single_delete'])->name('location.single.delete');
                Route::post('/admin/location-multiple-change-status',[DeliverablecitiesController::class, 'multiple_change_status'])->name('location.multiple.change.status');
                Route::post('/admin/location-multiple-delete',[DeliverablecitiesController::class, 'multiple_delete'])->name('location.multiple.delete');
            //

            // Coupon
                Route::resource('/coupons',CouponController::class);
                Route::get('/coupon/{id}/{status}', [CouponController::class, 'update_status'])->name('coupon.change-status');
                Route::post('/coupon-single-delete', [CouponController::class, 'single_delete'])->name('coupon.single.delete');
                Route::get('/coupon-restore/{id}', [CouponController::class, 'restore'])->name('coupon.restore');
                Route::post('/coupon-multiple-change-status',[CouponController::class, 'multiple_change_status'])->name('coupon.multiple.change.status');
                Route::post('/coupon-multiple-delete',[CouponController::class, 'multiple_delete'])->name('coupon.multiple.delete');

                Route::get('/get-product-brands', [CouponFrontController::class, 'get_brands'])->name('display.product-brands');
                Route::get('/coupon-download-template', [CouponController::class, 'download_coupon_template'])->name('coupon.download.template');
            //

            // Sales Transaction
                Route::resource('/admin/sales-transaction', SalesController::class);
                Route::post('/admin/sales-transaction/change-status', [SalesController::class, 'change_status'])->name('sales-transaction.change.status');
                Route::post('/admin/sales-transaction/{sales}', [SalesController::class, 'quick_update'])->name('sales-transaction.quick_update');
                Route::get('/admin/sales-transaction/view/{sales}', [SalesController::class, 'show'])->name('sales-transaction.view');
                Route::post('/admin/change-delivery-status', [SalesController::class, 'delivery_status'])->name('sales-transaction.delivery_status');


                Route::get('/admin/sales-transaction/view-payment/{sales}', [SalesController::class, 'view_payment'])->name('sales-transaction.view_payment');
                Route::post('/admin/sales-transaction/cancel-product', [SalesController::class, 'cancel_product'])->name('sales-transaction.cancel_product');
                Route::get('/sales-advance-search/', [SalesController::class, 'advance_index'])->name('admin.sales.list.advance-search');


                Route::get('/admin/report/sales', [ReportsController::class, 'sales'])->name('admin.report.sales');
                Route::get('/admin/report/sales_summary', [ReportsController::class, 'sales_summary'])->name('report.sales.summary');
                Route::get('/admin/report/delivery_status', [ReportsController::class, 'delivery_status'])->name('admin.report.delivery_status');
                Route::get('/admin/report/delivery_report/{id}', [ReportsController::class, 'delivery_report'])->name('admin.report.delivery_report');

                Route::get('/admin/sales-transaction/view-payment/{sales}', [SalesController::class, 'view_payment'])->name('sales-transaction.view_payment');
                Route::post('/admin/sales-transaction/cancel-product', [SalesController::class, 'cancel_product'])->name('sales-transaction.cancel_product');

                Route::post('/admin/payment-add-store',[SalesController::class, 'payment_add_store'])->name('payment.add.store');
                Route::get('/display-added-payments', [SalesController::class, 'display_payments'])->name('display.added-payments');
                Route::get('/display-delivery-history', [SalesController::class, 'display_delivery'])->name('display.delivery-history');

                Route::get('/sales/update-payment/{id}','EcommerceControllers\JoborderController@staff_edit_payment')->name('staff-edit-payment');
                Route::post('/sales/update-payment','EcommerceControllers\JoborderController@staff_update_payment')->name('staff-update-payment');
            //


            Route::get('/report/stock-card/{id}', [ReportsController::class, 'stock_card'])->name('report.product.stockcard');
        ###### Ecommerce Standard Routes ######




        ###### Template Builder Routes ######
            Route::resource('/template-categories', TemplateCategoryController::class);
            Route::resource('/templates', TemplateController::class);

        ###### Template Builder Routes ######
    });
});

// Pages Frontend
Route::get('/{any}', [FrontController::class, 'page'])->where('any', '.*');
