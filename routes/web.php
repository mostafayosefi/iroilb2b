<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\SitemapController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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
// site map
Route::get('/fa/sitemap.xml', [SitemapController::class, 'persian']);
Route::get('/en/sitemap.xml', [SitemapController::class, 'english']);
Route::get('/fa/sitemap.xml/companies', [SitemapController::class, 'companies']);
Route::get('/en/sitemap.xml/companies', [SitemapController::class, 'companies']);
Route::get('/fa/sitemap.xml/ads', [SitemapController::class, 'adsFa']);
Route::get('/en/sitemap.xml/ads', [SitemapController::class, 'adsEn']);
Route::get('/fa/sitemap.xml/pages', [SitemapController::class, 'pagesFa']);
Route::get('/en/sitemap.xml/pages', [SitemapController::class, 'pagesEn']);
Route::get('/fa/sitemap.xml/articles', [SitemapController::class, 'postFa']);
Route::get('/en/sitemap.xml/articles', [SitemapController::class, 'postEn']);
Route::get('/fa/sitemap.xml/categories', [SitemapController::class, 'catFa']);
Route::get('/en/sitemap.xml/categories', [SitemapController::class, 'catEn']);
Route::get('/fa/sitemap.xml/tags', [SitemapController::class, 'tagFa']);
Route::get('/en/sitemap.xml/tags', [SitemapController::class, 'tagEn']);
// admin
Route::get('/fa/admin{any}', [AdminController::class, 'index'])->where('any', '.*');
// login
Route::get('/en/auth', function () {
    return Socialite::driver('google')->redirect();
});
Route::get('/fa/auth', function () {
    return Socialite::driver('google')->redirect();
});
Route::get('/en/callback', [HomeController::class, 'auth']);
// site
Route::get('/{any}', [HomeController::class, 'index'])->where('any', '.*');

Auth::routes();
