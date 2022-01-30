<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginRegController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\MyAccountController;
use App\Http\Controllers\ShopViewController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ProductController;




Route::get('/',[HomeController::class,'home'])->name('home');

//RegistrationController
Route::get('/registration',[RegistrationController::class,'Index'])->name('pages.registration');
Route::post('/registration/create',[RegistrationController::class,'CreateUser'])->name('create.user');
Route::get('/login',[RegistrationController::class,'Login'])->name('pages.login');
Route::post('/make/login',[RegistrationController::class,'MakeLogin'])->name('make.login');
Route::post('/make/login/checkout',[RegistrationController::class,'MakeLoginCheckOut'])->name('make.login.checkout');

//MyAccountController
Route::get('/myaccount',[MyAccountController::class,'MyAccount'])->name('pages.myaccount')->middleware('login.auth');
Route::get('/myaccount/logout',[MyAccountController::class,'Logout'])->name('account.logout');
Route::post('/myaccount/edit',[MyAccountController::class,'MyaccountEdit'])->name('account.edit');

//Shop View
Route::get('/shopView/{shopId}',[ShopViewController::class,'ShopView'])->name('shop.view');

//cart
Route::get('/cart',[CartController::class,'Cart'])->name('cart');
Route::post('/add-to-cart',[CartController::class,'AddToCart'])->name('gen-add-to-cart');
Route::get('/mini-cart-data',[CartController::class,'MiniCartData'])->name('mini-cart-data');
Route::get('/mini-cart-sum',[CartController::class,'MiniCartSum'])->name('mini-cart-sum');
Route::get('/update-qty',[CartController::class,'UpdateQty']);
Route::get('remove-product/{productId}',[CartController::class,'RemoveCartProduct'])->name('remove-product');
Route::get('/mini-cart-test',[CartController::class,'MiniCartTest']);

//CheackOut
Route::get('/checkout',[CheckoutController::class,'Checkout'])->name('checkout');
Route::post('/checkout/final',[CheckoutController::class,'finalCheckout'])->name('finalCheckout');

//invoice Controller
Route::get('/checkoutInvoice/{invId}',[InvoiceController::class,'CheckoutInv'])->name('checkoutInv');

//search controller
Route::post('/shop/search/home',[SearchController::class,'ShopSearchHome'])->name('home.shop.search');
Route::post('/shop/search/campaign',[SearchController::class,'ShopSearchCampaign'])->name('home.campaign.search');

//campaign
Route::get('/campaign/{campaignName}',[CampaignController::class,'index'])->name('campaignById');
Route::get('/campaign/shop/{shopId}/{campaignName}',[CampaignController::class,'shopView'])->name('shopView.campaign');
Route::get('/all/products',[CampaignController::class,'allProducts'])->name('all.products');
Route::get('/all/products/shop/{shopId}',[CampaignController::class,'shopAllProducts'])->name('all.products.shops');


//products
Route::get('/product/details/{pId}/{shopId}',[ProductController::class,'productDetails'])->name('products.details');

//sell on amardokan
Route::get('/sellOnAmardokan', function () {
    return view('sellOnAmardokan.index');
})->name('sellOnAmardokan');