<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminNotficationController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FilterController;
use App\Http\Controllers\Admin\LabelsController;
use App\Http\Controllers\Admin\MenoSettingController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PdfController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RedirectController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\User\AdvertiseController;
use App\Http\Controllers\User\B2bPlusController;
use App\Http\Controllers\User\BlogController;
use App\Http\Controllers\User\CompanyController;
use App\Http\Controllers\User\FormController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\TableController;
use App\Http\Controllers\User\TicketController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserNotification;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->middleware('api')->namespace('api\vi')->group(function () {
    // ************************ Admin Only Access
    Route::middleware('auth:api')->group(function () {
        // admin dashboard
        Route::get('/admin/get', [AdminController::class, 'admin']);
        // product api CRUD
        Route::post('/product/create', [ProductController::class, 'store']);
        Route::get('/product/{id}', [ProductController::class, 'edit']);
        Route::put('/product/update/{id}', [ProductController::class, 'update']);
        Route::delete('/product/delete/{id}', [ProductController::class, 'delete']);
        // filter api CRUD
        Route::post('/filter/create', [FilterController::class, 'store']);
        Route::get('/filter/{id}', [FilterController::class, 'edit']);
        Route::put('/filter/update/{id}', [FilterController::class, 'update']);
        Route::delete('/filter/delete/{id}', [FilterController::class, 'delete']);
        // company api CRUD
        Route::get('/company/admin', [CompanyController::class, 'admin']);
        Route::get('/company/get/{id}', [CompanyController::class, 'get']);
        Route::post('/company/update/admin/{id}', [CompanyController::class, 'update']);
        // company api CRUD
        Route::get('/advertise/get', [AdvertiseController::class, 'index']);
        Route::get('/advertise/id/{id}', [AdvertiseController::class, 'get']);
        Route::delete('/advertise/delete/{id}', [AdvertiseController::class, 'delete']);
        Route::put('/advertise/update/{id}', [AdvertiseController::class, 'update']);
        // labels api CRUD
        Route::post('/label/create', [LabelsController::class, 'store']);
        Route::delete('/label/delete/{id}', [LabelsController::class, 'delete']);
        Route::get('/label/{id}', [LabelsController::class, 'edit']);
        Route::put('/label/update/{id}', [LabelsController::class, 'update']);
        // site setting api CRUD
        Route::post('/sitesetting/update', [SiteSettingController::class, 'update']);
        Route::delete('/sitesetting/delete/{text}', [SiteSettingController::class, 'delete']);
        // category api CRUD
        Route::delete('/category/delete/{id}', [CategoryController::class, 'delete']);
        Route::get('/category/{id}', [CategoryController::class, 'edit']);
        Route::post('/category/create', [CategoryController::class, 'store']);
        Route::put('/category/update/{id}', [CategoryController::class, 'update']);
        // post api CRUD
        Route::post('/post/create', [PostController::class, 'store']);
        Route::get('/post', [PostController::class, 'index']);
        Route::delete('/post/delete/{id}', [PostController::class, 'delete']);
        Route::get('/post/{id}', [PostController::class, 'edit']);
        Route::post('/post/update', [PostController::class, 'update']);
        // meno & footer api update
        Route::put('/meno/update', [MenoSettingController::class, 'update']);
        Route::put('/footer/update', [MenoSettingController::class, 'footer']);
        // get norfiacte
        Route::get('/admin/notficate', [AdminNotficationController::class, 'index']);
        Route::post('/admin/notficate/read', [AdminNotficationController::class, 'read']);
        // page api CRUD
        Route::post('/page/create', [PageController::class, 'store']);
        Route::get('/page', [PageController::class, 'index']);
        Route::delete('/page/delete/{id}', [PageController::class, 'delete']);
        Route::get('/page/{id}', [PageController::class, 'edit']);
        Route::post('/page/update', [PageController::class, 'update']);
        Route::post('/page/special/update', [PageController::class, 'special']);
        Route::get('/page/special/{id}', [PageController::class, 'get']);
        // redirect CRD
        Route::get('/redirect', [RedirectController::class, 'index']);
        Route::post('/redirect/create', [RedirectController::class, 'store']);
        Route::delete('/redirect/delete/{id}', [RedirectController::class, 'delete']);
        // get form
        Route::get('/form', [FormController::class, 'index']);
        Route::delete('/form/delete/{id}', [FormController::class, 'delete']);
        Route::get('/form/{id}', [FormController::class, 'get']);
        Route::put('/form/update/{id}', [FormController::class, 'update']);
        // notification
        Route::post('/notification/singlesend', [UserNotification::class, 'single']);
        Route::post('/notification/multisend', [UserNotification::class, 'multi']);
        Route::get('/notification', [UserNotification::class, 'index']);
        // user *
        Route::get('/users/all', [UserManagementController::class, 'index']);
        Route::put('/user/update', [UserManagementController::class, 'update']);
        // operators *
        Route::get('/operators/all', [PermissionsController::class, 'index']);
        Route::get('/operators/{id}', [PermissionsController::class, 'user']);
        Route::put('/operators/update', [PermissionsController::class, 'update']);
        // ticket
        Route::get('/ticket/', [TicketController::class, 'all']);
        Route::get('/ticket/single/{id}', [TicketController::class, 'single']);
        // table
        Route::post('/table/add', [TableController::class, 'store']);
        Route::get('/table/', [TableController::class, 'index']);
        Route::get('/table/id/{id}', [TableController::class, 'get']);
        Route::get('/table/pdf', [PdfController::class, 'make']);
        Route::delete('/table/delete/{id}', [TableController::class, 'delete']);
        Route::put('/table/update/{id}', [TableController::class, 'update']);
    });
    // ************************ User Only Access
    Route::middleware('UserAuth')->group(function () {
        // get user info
        Route::post('/user/check', [UserController::class, 'check']);
        Route::get('/user', [UserController::class, 'info']);
        Route::post('/user/changepassword', [UserController::class, 'change']);
        // notification
        Route::post('/notification/setting', [UserNotification::class, 'setting']);
        Route::get('/notification/get', [UserNotification::class, 'get']);
        Route::get('/user/notification', [UserNotification::class, 'user']);
        Route::post('/notification/usersend', [UserNotification::class, 'company']);
        // ticket
        Route::post('/ticket/new', [TicketController::class, 'store']);
        Route::get('/ticket/{id}', [TicketController::class, 'index']);
        Route::post('/ticket/update', [TicketController::class, 'update']);
        // company
        Route::get('/company/user', [CompanyController::class, 'user']);
        Route::post('/company/create', [CompanyController::class, 'store']);
        Route::get('/company/get/user/{id}', [CompanyController::class, 'getCompany']);
        Route::post('/company/update/{id}', [CompanyController::class, 'userUpdate']);
        // advertise
        Route::get('/advertise/user/{id}', [AdvertiseController::class, 'user']);
        Route::post('/advertise/create', [AdvertiseController::class, 'store']);
        Route::post('/advertise/delete/user', [AdvertiseController::class, 'trash']);
        Route::get('/advertise/bookmark', [AdvertiseController::class, 'bookmark']);
        // bookmark
        Route::post('/bookmark/add', [AdvertiseController::class, 'favoriteAdd']);
        Route::delete('/bookmark/remove', [AdvertiseController::class, 'favoriteDelete']);
    });
    // ************************ All Users Can Access
    // get site setting
    Route::get('/sitesetting', [SiteSettingController::class, 'index']);
    Route::get('/label', [LabelsController::class, 'index']);
    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/meno', [MenoSettingController::class, 'index']);
    // login and register
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/login/code', [UserController::class, 'sendcode']);
    Route::post('/login/check', [UserController::class, 'index']);
    Route::post('/login/auth', [UserController::class, 'autologin']);
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/register/auth', [UserController::class, 'authenticate']);
    Route::post('/register/done', [UserController::class, 'done']);
    // blog
    Route::get('/blog', [BlogController::class, 'index']);
    Route::get('/blog/categories', [BlogController::class, 'categories']);
    Route::get('/blog/labels', [BlogController::class, 'labels']);
    Route::get('/blog/post/{post}', [BlogController::class, 'post']);
    Route::post('/blog/rate', [BlogController::class, 'rate']);
    // b2b plus
    Route::get('/b2bplus', [B2bPlusController::class, 'index']);
    Route::get('/b2bplus/about', [B2bPlusController::class, 'about']);
    Route::get('/b2bplus/contact', [B2bPlusController::class, 'contact']);
    Route::get('/b2bplus/faq', [B2bPlusController::class, 'faq']);
    Route::get('/pages/home', [PageController::class, 'home']);
    Route::get('/pages/{slug}', [B2bPlusController::class, 'page']);
    // form input
    Route::post('/form/faq', [FormController::class, 'faq']);
    Route::post('/form/contact', [FormController::class, 'contact']);
    Route::post('/form/feedback', [FormController::class, 'feedback']);
    Route::get('/feedback', [FormController::class, 'getfeedback']);
    // company
    Route::get('/company/all', [CompanyController::class, 'all']);
    Route::get('/company/single/{slug}', [CompanyController::class, 'single']);
    Route::get('/product', [ProductController::class, 'index']);
    Route::get('/filter', [FilterController::class, 'index']);
    // ads
    Route::get('/advertise/single/{slug}', [AdvertiseController::class, 'single']);
    Route::get('/advertise/all', [AdvertiseController::class, 'all']);
    // get all filter tag
    Route::get('/tags', [HomeController::class, 'tags']);
    Route::get('/tags/{slug}', [HomeController::class, 'filter']);
    // search
    Route::get('/search/{text}', [HomeController::class, 'search']);
    //table
    Route::get('/table/all', [TableController::class, 'all']);
});
