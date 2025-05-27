<?php

use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showCustomLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'customLogin']);

Route::get('/templatelist', function () {
    return view('templatelist');
})->middleware(['auth'])->name('templatelist');

// Route::get('/home', function () {
//     return view('home');
// })->middleware(['auth'])->name('home');

// Route::get('/dashboard/search', [ManualController::class, 'search'])->name('manual.search');

use App\Http\Controllers\TemplateController;

Route::get('/templatelist', [TemplateController::class, 'index'])
    ->middleware(['auth'])
    ->name('templatelist');

use App\Http\Controllers\CssController;
use App\Http\Controllers\JsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MemberController;

Route::middleware(['auth'])->group(function () {
    Route::get('/csslist', [CssController::class, 'index'])->name('csslist');
    Route::get('/jslist', [JsController::class, 'index'])->name('jslist');
    Route::get('/userlist', [UserController::class, 'index'])->name('userlist');
    Route::get('/css/create', [CssController::class, 'create'])->name('css.create');
    Route::post('/css/store', [CssController::class, 'store'])->name('css.store');
    Route::get('/js/create', [JsController::class, 'create'])->name('js.create');
    Route::post('/js/store', [JsController::class, 'store'])->name('js.store');

    Route::get('/memberlist', [MemberController::class, 'index'])->name('memberlist');

    // 新規登録フォーム表示
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');

    // 新規登録データ保存
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
});

Route::get('/template/create', [TemplateController::class, 'create'])->name('template.create');

Route::post('/template/store', [TemplateController::class, 'store'])->name('template.store');

use Illuminate\Support\Facades\Auth;
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login'); // ログアウト後にログインページへリダイレクト
})->name('logout');


use App\Http\Controllers\HomeController;

Route::get('/home', [HomeController::class, 'index'])
    ->middleware(['auth'])
    ->name('home');
