<?php

/****************   Model binding into route **************************/
use LaraCall\Http\Controllers\IpnController;
use LaraCall\Http\Controllers\Subscriber\ArticleCategoriesController;

//
//Route::model('article', 'LaraCall\Article');
//Route::model('articlecategory', 'LaraCall\ArticleCategory');
//Route::model('language', 'LaraCall\Language');
//Route::model('photoalbum', 'LaraCall\PhotoAlbum');
//Route::model('photo', 'LaraCall\Photo');
//Route::model('user', 'LaraCall\User');
//Route::pattern('id', '[0-9]+');
//Route::pattern('slug', '[0-9a-z-_]+');

/***************    Site routes  **********************************/


Route::group(['as' => 'web'], function () {
    Route::get('/', \LaraCall\Http\Controllers\HomeController::class . '@index');
    Route::get('home', \LaraCall\Http\Controllers\HomeController::class . '@index');
    Route::get('about', \LaraCall\Http\Controllers\PagesController::class . '@about');
    Route::get('contact', \LaraCall\Http\Controllers\PagesController::class . '@contact');
    Route::get('articles', \LaraCall\Http\Controllers\ArticlesController::class . '@index');
    Route::get('article/{slug}', \LaraCall\Http\Controllers\ArticlesController::class . '@show');
    Route::get('photo/{id}', \LaraCall\Http\Controllers\PhotoController::class . '@show');
    Route::get('/delivery/{token}', \LaraCall\Http\Controllers\DeliveryController::class . '@show');
});

Route::controllers([
    'auth'     => \LaraCall\Http\Controllers\Auth\AuthController::class,
    'password' => \LaraCall\Http\Controllers\Auth\PasswordController::class,
]);


/*
 * API ROUTES
 */
Route::group(['prefix' => 'api', 'middleware' => 'api', 'as' => 'api'], function () {
    Route::match('POST', 'paypal/ipn', ['uses' => IpnController::class . '@payPalIpn']);
});

/***************    Admin routes  **********************************/
Route::group(['prefix' => 'admin', 'middleware' => 'subscriber', 'namespace' => ''], function () {

    # Admin Dashboard
    Route::get('dashboard', LaraCall\Http\Controllers\Subscriber\DashboardController::class . '@index');

    # Language
    Route::get('language/data', LaraCall\Http\Controllers\Subscriber\LanguageController::class . '@data');
    Route::get('language/{language}/show',
        LaraCall\Http\Controllers\Subscriber\LanguageController::class . '@show');
    Route::get('language/{language}/edit',
        LaraCall\Http\Controllers\Subscriber\LanguageController::class . '@edit');
    Route::get('language/{language}/delete',
        LaraCall\Http\Controllers\Subscriber\LanguageController::class . '@delete');
    Route::resource('language', LaraCall\Http\Controllers\Subscriber\LanguageController::class);

    # Article category
    Route::get('articlecategory/data', ArticleCategoriesController::class . '@data');
    Route::get('articlecategory/{articlecategory}/show', ArticleCategoriesController::class . '@show');
    Route::get('articlecategory/{articlecategory}/edit', ArticleCategoriesController::class . '@edit');
    Route::get('articlecategory/{articlecategory}/delete', ArticleCategoriesController::class . '@delete');
    Route::get('articlecategory/reorder', ArticleCategoriesController::class . '@order');
    Route::resource('articlecategory', ArticleCategoriesController::class);

    # Articles
    Route::get('article/data', \LaraCall\Http\Controllers\Subscriber\ArticleController::class . '@data');
    Route::get('article/{article}/show', \LaraCall\Http\Controllers\Subscriber\ArticleController::class . '@show');
    Route::get('article/{article}/edit', \LaraCall\Http\Controllers\Subscriber\ArticleController::class . '@edit');
    Route::get('article/{article}/delete', \LaraCall\Http\Controllers\Subscriber\ArticleController::class . '@delete');
    Route::get('article/reorder', \LaraCall\Http\Controllers\Subscriber\ArticleController::class . '@getReorder');
    Route::resource('article', \LaraCall\Http\Controllers\Subscriber\ArticleController::class);

    # Photo Album
    Route::get('photoalbum/data', \LaraCall\Http\Controllers\Subscriber\PhotoAlbumController::class . '@data');
    Route::get('photoalbum/{photoalbum}/show',
        \LaraCall\Http\Controllers\Subscriber\PhotoAlbumController::class . '@show');
    Route::get('photoalbum/{photoalbum}/edit',
        \LaraCall\Http\Controllers\Subscriber\PhotoAlbumController::class . '@edit');
    Route::get('photoalbum/{photoalbum}/delete',
        \LaraCall\Http\Controllers\Subscriber\PhotoAlbumController::class . '@delete');
    Route::resource('photoalbum', \LaraCall\Http\Controllers\Subscriber\PhotoAlbumController::class);

    # Photo
    Route::get('photo/data', \LaraCall\Http\Controllers\Subscriber\PhotoController::class . '@data');
    Route::get('photo/{photo}/show', \LaraCall\Http\Controllers\Subscriber\PhotoController::class . '@show');
    Route::get('photo/{photo}/edit', \LaraCall\Http\Controllers\Subscriber\PhotoController::class . '@edit');
    Route::get('photo/{photo}/delete', \LaraCall\Http\Controllers\Subscriber\PhotoController::class . '@delete');
    Route::resource('photo', \LaraCall\Http\Controllers\Subscriber\PhotoController::class);

    # Users
    Route::get('user/data', \LaraCall\Http\Controllers\Subscriber\UserController::class . '@data');
    Route::get('user/{user}/show', \LaraCall\Http\Controllers\Subscriber\UserController::class . '@show');
    Route::get('user/{user}/edit', \LaraCall\Http\Controllers\Subscriber\UserController::class . '@edit');
    Route::get('user/{user}/delete', \LaraCall\Http\Controllers\Subscriber\UserController::class . '@delete');
    Route::resource('user', \LaraCall\Http\Controllers\Subscriber\UserController::class);
});

Route::group(['prefix' => 'root', 'middleware' => 'god', 'namespace' => ''], function () {
    Route::get('/userinfo/', '\\' . \LaraCall\Http\Controllers\God\UserController::class . '@listUsersAction');
//    Route::get('/userinfo/{email}', '\\' . \LaraCall\Http\God\UserController::class . '' );
//    Route::get('/userinfo/{email}/{pin}', '\\' . );
});
