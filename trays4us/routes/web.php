<?php

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
// Route::get('/about', [WebsiteController::class, 'about']);


//Auth::routes();

Route::get(
    'clear-cache',
    function () {
        \Artisan::call('config:cache');
        \Artisan::call('cache:clear');
        \Artisan::call('config:clear');
        \Artisan::call('optimize:clear');
        return redirect()->back();
    }
);

//----------------------------------------------------------------------------------------------------------------------

Route::get('/sitemap', 'App\Http\Controllers\SiteController@sitemap')->name('sitemap');

//----------------------------------------------------------------------------------------------------------------------

Route::redirect('customtray','create-custom');
Route::permanentRedirect('/resell', '/');
Route::permanentRedirect('/care', '/');
// Front end routes

Route::get('/image/restrict', function (Request $request) {
    Log::info('Image access attempt');
});

Route::get('/sign-in', 'App\Http\Controllers\UsersController@signin')->name('sign-in');
Route::post('/signin_submitted', 'App\Http\Controllers\UsersController@signin_submitted')->name('signin_submitted');
Route::get('/sign-up', 'App\Http\Controllers\UsersController@customer_signup')->name('sign-up');
Route::post('/customer-signup-submitted', 'App\Http\Controllers\UsersController@customer_signup_submitted')->name('customer-signup-submitted');
Route::get('/customer-signup-verification', 'App\Http\Controllers\UsersController@customer_signup_verification')->name('customer-signup-verification');

Route::get('auth/google', 'App\Http\Controllers\SocialController@redirectToGoogle')->name('auth.google');
Route::get('auth/google/callback', 'App\Http\Controllers\SocialController@handleGoogleCallback');

Route::get('auth/facebook', 'App\Http\Controllers\SocialController@redirectToFacebook')->name('auth.facebook');
Route::get('auth/facebook/callback', 'App\Http\Controllers\SocialController@handleFacebookCallback');

Route::get('/term-condition', 'App\Http\Controllers\SiteController@term_condition')->name('term-condition');
Route::get('/privacy-policy', 'App\Http\Controllers\SiteController@privacy_policy')->name('privacy-policy');
Route::get('/contact-us', 'App\Http\Controllers\SiteController@contact_us')->name('contact-us');

Route::get('/forgot_password_customer', 'App\Http\Controllers\UsersController@forgot_password_customer')->name('forgot_password_customer');
Route::get('/reset_password', 'App\Http\Controllers\UsersController@reset_password')->name('reset_password');
Route::post('/reset_update_password', 'App\Http\Controllers\UsersController@reset_update_password')->name('reset_update_password');


//Route::get('/home', 'App\Http\Controllers\SiteController@home')->name('home');
Route::get('/', 'App\Http\Controllers\SiteController@home')->name('home');
Route::get('/ajax-home-more-products', 'App\Http\Controllers\SiteController@ajax_home_more_products')->name('ajax-home-more-products');


//----------------------------------------------------------------------------------------------------------------------
Route::get('/quickbooks/connect', 'App\Http\Controllers\QuickBooksController@connect')->name('quickbooks.connect');
Route::get('/quickbooks/callback','App\Http\Controllers\QuickBooksController@callback')->name('quickbooks.callback');
Route::get('/create-customer', 'App\Http\Controllers\QuickBooksController@createCustomer')->name('quickbooks.create-customer');
Route::get('/qb-place-order', 'App\Http\Controllers\QuickBooksController@quickbook_place_order')->name('quickbooks.quickbook_place_order');
Route::get('/qb-place-order2', 'App\Http\Controllers\QuickBooksController@quickbook_place_order2')->name('quickbooks.quickbook_place_order2');


//----------------------------------------------------------------------------------------------------------------------
Route::get('/create-custom', 'App\Http\Controllers\ArtistController@create_custom')->name('create-custom');
Route::get('/artists', 'App\Http\Controllers\ArtistController@license_artwork')->name('license-artwork');

Route::get('/artists/{slug}', 'App\Http\Controllers\ArtistController@artist_detail')->name('artist-detail');


//---------------------------------------------- Shop ------------------------------------

Route::get('/shop-in-wholesale', 'App\Http\Controllers\ShopController@shop_in_wholesale')->name('shop-in-wholesale');
Route::get('/products', 'App\Http\Controllers\ShopController@shop_in_wholesale')->name('frontend.products');
Route::get('/filter-products', 'App\Http\Controllers\ShopController@filter_products')->name('filter-products');
Route::get('/product/{slug}', 'App\Http\Controllers\ShopController@product_detail')->name('product-detail');
Route::post('/search-tag-designs-are-available', 'App\Http\Controllers\ShopController@search_tag_designs_are_available')->name('search-tag-designs-are-available');

//---------------------------------------------- OTP for front end user when sign in------------------------------------

Route::get('verify-otp', 'App\Http\Controllers\UsersController@verify_otp')->name('verify.otp'); // verify otp page.
Route::post('verify-otp', 'App\Http\Controllers\UsersController@verify_otp_ajax')->name('verify.otp'); // verify otp ajax request.
Route::post('resend-otp', 'App\Http\Controllers\UsersController@resend_otp_ajax')->name('resend.otp'); // resend otp ajax request.
 Route::get('/upload-your-work', 'App\Http\Controllers\ArtistController@upload_your_work')->name('upload-your-work');
Route::group(['middleware' => ['App\Http\Middleware\IsCustomer']], function () {

    Route::get('/profile', 'App\Http\Controllers\UsersController@profile')->name('customer-profile');
    Route::post('/profile-update-save', 'App\Http\Controllers\UsersController@profile_update_save')->name('profile-update-save');

    Route::get('/change-password', 'App\Http\Controllers\UsersController@change_password')->name('change-password');
    Route::post('/change-password-save', 'App\Http\Controllers\UsersController@change_password_save')->name('change-password-save');


    Route::get('/my-account', 'App\Http\Controllers\UsersController@my_account')->name('my-account');

    //Wishlist
    Route::post('/add-wishlist', 'App\Http\Controllers\ShopController@add_wishlist')->name('add-wishlist');
    Route::get('/wishlist', 'App\Http\Controllers\ShopController@wishlist')->name('wishlist');
    Route::post('/remove-wishlist', 'App\Http\Controllers\ShopController@remove_wishlist')->name('remove-wishlist');
    Route::post('/update-wishlist', 'App\Http\Controllers\ShopController@update_wishlist')->name('update-wishlist');
    Route::post('/add-to-cart-all-wishlist-item', 'App\Http\Controllers\ShopController@add_to_cart_all_wishlist_item')->name('add-to-cart-all-wishlist-item');
    Route::post('/add-to-wishlist-all-ordered-item', 'App\Http\Controllers\ShopController@add_to_wishlist_all_ordered_item')->name('add-to-wishlist-all-ordered-item');

    // Cart

    Route::get('/cart', 'App\Http\Controllers\ShopController@cart')->name('cart');
    Route::post('/add-to-cart', 'App\Http\Controllers\ShopController@add_to_cart')->name('add-to-cart');
    Route::post('/remove-cart', 'App\Http\Controllers\ShopController@remove_cart')->name('remove-cart');
    Route::post('/update-cart', 'App\Http\Controllers\ShopController@update_cart')->name('update-cart');
    Route::post('/add-to-cart-all-ordered-item', 'App\Http\Controllers\ShopController@add_to_cart_all_ordered_item')->name('add-to-cart-all-ordered-item');

    // Place order
    Route::post('/place-order', 'App\Http\Controllers\ShopController@place_order')->name('place-order');
    Route::get('/my-order', 'App\Http\Controllers\ShopController@my_order')->name('my-order');
    Route::get('/order-detail/{id}', 'App\Http\Controllers\ShopController@order_detail')->name('order-detail');

    // Upload your work
   
    Route::post('/save-artist-work', 'App\Http\Controllers\ArtistController@save_artist_work')->name('save-artist-work');
    Route::get('/preview-your-work', 'App\Http\Controllers\ArtistController@preview_your_work')->name('preview-your-work');
    Route::post('/save-preview-your-work', 'App\Http\Controllers\ArtistController@save_preview_your_work')->name('save-preview-your-work');
    Route::get('/edit-product/{id}', 'App\Http\Controllers\ArtistController@edit_product')->name('customer.edit-product');
    Route::post('/save-edit-product', 'App\Http\Controllers\ArtistController@save_edit_product')->name('save-edit-product');
    Route::get('/download-product/{id}', 'App\Http\Controllers\ArtistController@download_product')->name('customer.download-product');
    Route::post('/is_real_product_create', 'App\Http\Controllers\ArtistController@is_real_product_create')->name('customer.is_real_product_create');


    // Delete custom product by user
    //Wishlist
    Route::get('/delete-customizer-product-by-user', 'App\Http\Controllers\ShopController@delete_customizer_product_by_user')->name('delete-customizer-product-by-user');

});
Route::get('/logout', 'App\Http\Controllers\UsersController@logout')->name('logout');

//----------------------------------------------------------------------------------------------------------------------

// Backend

Route::get('/tfubacksecurelogin', 'App\Http\Controllers\admin\AdminController@admin')->name('tfubacksecurelogin');
Route::post('/admin_submitted', 'App\Http\Controllers\admin\AdminController@admin_submitted')->name('admin_submitted');
Route::get('/admin_logout', 'App\Http\Controllers\admin\AdminController@admin_logout')->name('admin_logout');

Route::get('get-state-by-country-id', 'App\Http\Controllers\admin\ProductController@get_state_by_country_id')->name('get-state-by-country-id');

// Admin login
Route::get('show_2fa_Form', 'App\Http\Controllers\admin\AdminController@show2faForm')->name('show_2fa_Form');
Route::post('admin_verify2fa_post', 'App\Http\Controllers\admin\AdminController@verify2fa')->name('admin_verify2fa_post');


Route::group(['prefix' => 'admin','middleware' => ['App\Http\Middleware\IsAdmin','App\Http\Middleware\CheckPasswordAge']], function () {

    Route::get('/admin-dashboard', 'App\Http\Controllers\admin\AdminController@admin_dashboard')->name('admin-dashboard');
    Route::get('/profile', 'App\Http\Controllers\admin\AdminController@profile')->name('profile');
    Route::post('/profile-update', 'App\Http\Controllers\admin\AdminController@profile_update')->name('profile-update');

    // Change password
    Route::get('/change-password', 'App\Http\Controllers\admin\AdminController@change_password')->name('admin.change-password');
    Route::post('/change-password-save', 'App\Http\Controllers\admin\AdminController@change_password_save')->name('admin.change-password-save');

    // Setting
    Route::get('/site-setting', 'App\Http\Controllers\admin\AdminController@site_setting')->name('site-setting');
    Route::post('/site-update', 'App\Http\Controllers\admin\AdminController@site_update')->name('site-update');

    // Homepage slider
    Route::get('homepage-slider','App\Http\Controllers\admin\AdminGeneralController@slider_listing')->name('homepage-slider');
    Route::get('add-homepage-slider','App\Http\Controllers\admin\AdminGeneralController@add_homepage_slider')->name('add-homepage-slider');
    Route::post('add-homepage-slider-submitted','App\Http\Controllers\admin\AdminGeneralController@add_homepage_slider_submitted')->name('add-homepage-slider-submitted');
    Route::get('edit-homepage-slider','App\Http\Controllers\admin\AdminGeneralController@edit_homepage_slider')->name('edit-homepage-slider');
    Route::post('edit-homepage-slider-submitted','App\Http\Controllers\admin\AdminGeneralController@edit_homepage_slider_submitted')->name('edit-homepage-slider-submitted');
    Route::get('change-slider-status','App\Http\Controllers\admin\AdminGeneralController@change_slider_status')->name('change-slider-status');
    Route::get('sort-homepage-slider', 'App\Http\Controllers\admin\AdminGeneralController@sort_homepage_slider')->name('sort-homepage-slider');
    Route::post('sort-homepage-slider-submitted', 'App\Http\Controllers\admin\AdminGeneralController@sortHomepageSliderSubmitted')->name('sort-homepage-slider-submitted');
    Route::get('slider-setting','App\Http\Controllers\admin\AdminGeneralController@slider_setting')->name('slider-setting');
    Route::post('slider-setting-submitted','App\Http\Controllers\admin\AdminGeneralController@slider_setting_submitted')->name('slider-setting-submitted');

    // Arists
    Route::get('artists','App\Http\Controllers\admin\ArtistController@artist_listing')->name('artists');
    Route::get('add-artist','App\Http\Controllers\admin\ArtistController@add_artist')->name('add-artist');
    Route::post('add-artist-submitted','App\Http\Controllers\admin\ArtistController@add_artist_submitted')->name('add-artist-submitted');
    Route::get('edit-artist','App\Http\Controllers\admin\ArtistController@edit_artist')->name('edit-artist');
    Route::post('edit-artist-submitted','App\Http\Controllers\admin\ArtistController@edit_artist_submitted')->name('edit-artist-submitted');
    Route::get('change-artist-status','App\Http\Controllers\admin\ArtistController@change_artist_status')->name('change-artist-status');
    Route::get('sort-artist', 'App\Http\Controllers\admin\ArtistController@sort_artist')->name('sort-artist');
    Route::post('sort-artist-submitted', 'App\Http\Controllers\admin\ArtistController@sort_artist_submitted')->name('sort-artist-submitted');
    Route::get('delete-artist-logo','App\Http\Controllers\admin\ArtistController@delete_artist_logo')->name('delete-artist-logo');
    Route::get('delete-artist-photo','App\Http\Controllers\admin\ArtistController@delete_artist_photo')->name('delete-artist-photo');
    Route::post('change-artist-visibility', 'App\Http\Controllers\admin\ArtistController@change_artist_visibility')->name('change-artist-visibility');

    // Customers
    Route::get('customer','App\Http\Controllers\admin\AdminController@customer_listing')->name('customer');
    Route::get('add-customer','App\Http\Controllers\admin\AdminController@add_customer')->name('add-customer');
    Route::post('add-customer-submitted','App\Http\Controllers\admin\AdminController@add_customer_submitted')->name('add-customer-submitted');
    Route::get('edit-customer','App\Http\Controllers\admin\AdminController@edit_customer')->name('edit-customer');
    Route::post('edit-customer-submitted','App\Http\Controllers\admin\AdminController@edit_customer_submitted')->name('edit-customer-submitted');
    Route::get('change-customer-status','App\Http\Controllers\admin\AdminController@change_customer_status')->name('change-customer-status');
    Route::get('download-customer-csv','App\Http\Controllers\admin\AdminController@download_customer_csv')->name('download-customer-csv');
    Route::post('import-customers','App\Http\Controllers\admin\AdminController@import_customers')->name('import-customers');

    // Product style
    Route::get('product-style','App\Http\Controllers\admin\AdminGeneralController@product_style_listing')->name('product-style');
    Route::get('add-product-style','App\Http\Controllers\admin\AdminGeneralController@add_product_style')->name('add-product-style');
    Route::post('add-product-style-submitted','App\Http\Controllers\admin\AdminGeneralController@add_product_style_submitted')->name('add-product-style-submitted');
    Route::get('edit-product-style','App\Http\Controllers\admin\AdminGeneralController@edit_product_style')->name('edit-product-style');
    Route::post('edit-product-style-submitted','App\Http\Controllers\admin\AdminGeneralController@edit_product_style_submitted')->name('edit-product-style-submitted');
    Route::get('change-product-style-status','App\Http\Controllers\admin\AdminGeneralController@change_product_style_status')->name('change-product-style-status');

    // Product style
    Route::get('product-customizable','App\Http\Controllers\admin\AdminGeneralController@product_customizable_listing')->name('product-customizable');
    Route::get('add-product-customizable','App\Http\Controllers\admin\AdminGeneralController@add_product_customizable')->name('add-product-customizable');
    Route::post('add-product-customizable-submitted','App\Http\Controllers\admin\AdminGeneralController@add_product_customizable_submitted')->name('add-product-customizable-submitted');
    Route::get('edit-product-customizable','App\Http\Controllers\admin\AdminGeneralController@edit_product_customizable')->name('edit-product-customizable');
    Route::post('edit-product-customizable-submitted','App\Http\Controllers\admin\AdminGeneralController@edit_product_customizable_submitted')->name('edit-product-customizable-submitted');
    Route::get('change-product-customizable-status','App\Http\Controllers\admin\AdminGeneralController@change_product_customizable_status')->name('change-product-customizable-status');
    Route::post('save-customizable-type-relation', 'App\Http\Controllers\admin\AdminGeneralController@save_customizable_type_relation')->name('save-customizable-type-relation');

    // Product badges
    Route::get('product-badges','App\Http\Controllers\admin\ProductController@product_badges_listing')->name('product-badges');
    Route::get('add-badge','App\Http\Controllers\admin\ProductController@add_badge')->name('add-badge');
    Route::post('add-badge-submitted','App\Http\Controllers\admin\ProductController@add_badge_submitted')->name('add-badge-submitted');
    Route::get('edit-badge','App\Http\Controllers\admin\ProductController@edit_badge')->name('edit-badge');
    Route::post('edit-badge-submitted','App\Http\Controllers\admin\ProductController@edit_badge_submitted')->name('edit-badge-submitted');
    Route::get('change-badge-status','App\Http\Controllers\admin\ProductController@change_badge_status')->name('change-badge-status');


    // Product category
    Route::get('/product-types', 'App\Http\Controllers\admin\AdminGeneralController@product_types_listing')->name('product-types');
    Route::get('/add-product-type', 'App\Http\Controllers\admin\AdminGeneralController@add_product_type')->name('add-product-type');
    Route::get('/edit-product-type', 'App\Http\Controllers\admin\AdminGeneralController@edit_product_type')->name('edit-product-type');
    Route::post('/add-product-type-submitted', 'App\Http\Controllers\admin\AdminGeneralController@product_type_submitted')->name('add-product-type-submitted');
    Route::post('/edit-product-type-submitted', 'App\Http\Controllers\admin\AdminGeneralController@edit_product_type_submitted')->name('edit-product-type-submitted');
    Route::get('/change-product-type-status', 'App\Http\Controllers\admin\AdminGeneralController@change_product_type_status')->name('change-product-type-status');
    Route::get('delete-product-type-photo','App\Http\Controllers\admin\AdminGeneralController@delete_product_type_photo')->name('delete-product-type-photo');
    Route::get('/save-case-pack', 'App\Http\Controllers\admin\AdminGeneralController@save_case_pack')->name('save-case-pack');

    // Products
    Route::get('/generate_products_slug', 'App\Http\Controllers\admin\ProductController@generate_products_slug')->name('generate_products_slug');
    Route::get('/generate_artist_slug', 'App\Http\Controllers\admin\ArtistController@generate_artist_slug')->name('generate_artist_slug');

    Route::get('/products-listing', 'App\Http\Controllers\admin\ProductController@products_listing')->name('products-listing');
    Route::get('/add-product', 'App\Http\Controllers\admin\ProductController@add_product')->name('add-product');
    Route::get('/edit-product', 'App\Http\Controllers\admin\ProductController@edit_product')->name('edit-product');
    Route::post('/add-product-submitted', 'App\Http\Controllers\admin\ProductController@product_submitted')->name('add-product-submitted');
    Route::post('/edit-product-submitted', 'App\Http\Controllers\admin\ProductController@edit_product_submitted')->name('edit-product-submitted');
    Route::get('/change-product-status', 'App\Http\Controllers\admin\ProductController@change_product_status')->name('change-product-status');
    Route::get('get-sub-product-type-by-id', 'App\Http\Controllers\admin\ProductController@get_sub_product_type_by_id')->name('get-sub-product-type-by-id');
    Route::get('get-autocomplete-product-tag', 'App\Http\Controllers\admin\ProductController@get_autocomplete_product_tag')->name('get-autocomplete-product-tag');
    Route::post('/store-product-gallery', 'App\Http\Controllers\admin\ProductController@store_product_gallery')->name('store-product-gallery');
    Route::get('/delete-product-image', 'App\Http\Controllers\admin\ProductController@delete_product_image')->name('delete-product-image');
    Route::get('get-case-pack-by-types','App\Http\Controllers\admin\ProductController@get_case_pack_by_types')->name('get-case-pack-by-types');
    Route::delete('delete-bluk-product','App\Http\Controllers\admin\ProductController@delete_bluk_product')->name('delete-bluk-product');
    Route::get('get-minimum-order-quantity-by-design','App\Http\Controllers\admin\ProductController@get_minimum_order_quantity_by_design')->name('get-minimum-order-quantity-by-design');
    Route::get('export-product','App\Http\Controllers\admin\ProductController@export_product')->name('export-product');
    Route::get('customer-autocomplete','App\Http\Controllers\admin\ProductController@customer_autocomplete')->name('customer-autocomplete');
    Route::get('/generate-pdf-customizer-product', 'App\Http\Controllers\admin\ProductController@generate_pdf_customizer_product')->name('generate-pdf-customizer-product');



    // Mass upload
	Route::get('product-mass-upload', 'App\Http\Controllers\admin\ProductController@product_mass_upload')->name('product-mass-upload');
    Route::post('mass-upload-save', 'App\Http\Controllers\admin\ProductController@mass_upload_save')->name('mass-upload-save');
    Route::post('sortable-mass-upload-images', 'App\Http\Controllers\admin\ProductController@sortable_mass_upload_images')->name('sortable-mass-upload-images');
    Route::post('create-product-from-mass-upload', 'App\Http\Controllers\admin\ProductController@create_product_from_mass_upload')->name('create-product-from-mass-upload');
    //Route::post('modify-single-product-record', 'App\Http\Controllers\admin\ProductController@modify_single_product_record')->name('modify-single-product-record');

    Route::get('customizer-processing-time','App\Http\Controllers\admin\ProductController@customizer_processing_time')->name('customizer-processing-time');


    // Tags
    Route::get('tags','App\Http\Controllers\admin\ProductController@tag_listing')->name('tags');
    Route::get('add-tag','App\Http\Controllers\admin\ProductController@add_tag')->name('add-tag');
    Route::post('add-tag-submitted','App\Http\Controllers\admin\ProductController@add_tag_submitted')->name('add-tag-submitted');
    Route::get('bulk-tag-manager','App\Http\Controllers\admin\ProductController@bulk_tag_manager')->name('bulk-tag-manager');
    Route::post('bulk-tag-manager-submitted','App\Http\Controllers\admin\ProductController@bulk_tag_manager_submitted')->name('bulk-tag-manager-submitted');
    Route::get('get-products-by-autocomplete','App\Http\Controllers\admin\ProductController@get_products_by_autocomplete')->name('get-products-by-autocomplete');
    Route::get('edit-tag','App\Http\Controllers\admin\ProductController@edit_tag')->name('edit-tag');
    Route::post('edit-tag-submitted','App\Http\Controllers\admin\ProductController@edit_tag_submitted')->name('edit-tag-submitted');
    Route::get('change-tag-status','App\Http\Controllers\admin\ProductController@change_tag_status')->name('change-tag-status');
    Route::get('get-search-tag-listing','App\Http\Controllers\admin\ProductController@get_search_tag_listing')->name('get-search-tag-listing');
    Route::get('change-search-tag-status','App\Http\Controllers\admin\ProductController@change_search_tag_status')->name('change-search-tag-status');


    // Orders
    Route::get('/all-orders', 'App\Http\Controllers\admin\OrderController@all_orders')->name('all-orders');
    Route::get('/change-order-process', 'App\Http\Controllers\admin\OrderController@change_order_process')->name('change-order-process');
    Route::get('/order-item-detail', 'App\Http\Controllers\admin\OrderController@order_item_detail')->name('order-item-detail');
    Route::get('/cancel-order', 'App\Http\Controllers\admin\OrderController@cancel_order')->name('cancel-order');
    Route::get('/edit-order/{order_id}', 'App\Http\Controllers\admin\OrderController@edit_order')->name('edit-order');
    Route::post('edit-order-submitted','App\Http\Controllers\admin\OrderController@edit_order_submitted')->name('edit-order-submitted');
    Route::get('delete-order-items','App\Http\Controllers\admin\OrderController@delete_order_items')->name('delete-order-items');

    // Cart tracking items in admin side
    Route::get('/all-cart-items', 'App\Http\Controllers\admin\OrderController@all_cart_items')->name('all-cart-items');
    Route::get('/cart-item-detail', 'App\Http\Controllers\admin\OrderController@cart_item_detail')->name('cart-item-detail');


    // Countries
    Route::get('/all-countries', 'App\Http\Controllers\admin\AdminController@all_countries')->name('all-countries');
    Route::get('/change-country-status', 'App\Http\Controllers\admin\AdminController@change_country_status')->name('change-country-status');

    // States
    Route::get('all-states','App\Http\Controllers\admin\AdminController@all_states_listings')->name('all-states');
    Route::get('add-state','App\Http\Controllers\admin\AdminController@add_state')->name('add-state-style');
    Route::post('add-state-submitted','App\Http\Controllers\admin\AdminController@add_state_submitted')->name('add-state-submitted');
    Route::get('edit-state','App\Http\Controllers\admin\AdminController@edit_state')->name('edit-state');
    Route::post('edit-state-submitted','App\Http\Controllers\admin\AdminController@edit_state_submitted')->name('edit-state-submitted');
    Route::get('change-state-status','App\Http\Controllers\admin\AdminController@change_state_status')->name('change-state-status');



});


