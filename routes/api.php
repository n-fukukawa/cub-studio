<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;

/****************************************************
 * auth
 ****************************************************/
//認証中のユーザー
Route::get('/auth', function(){ return Auth::user(); })->name('auth');
//登録
Route::post('/register', [RegisteredUserController::class, 'register'])->middleware('guest')->name('register');
//ログイン
Route::post('/login', [AuthenticatedSessionController::class, 'login'])->middleware('guest')->name('login');
//ログアウト
Route::post('/logout', [AuthenticatedSessionController::class, 'logout'])->middleware('auth')->name('logout');

/***************************************************
 * post
 ***************************************************/
//一覧
Route::get('/post', [PostController::class, 'index'])->name('post.index');
//検索結果
Route::get('/post/search', [PostController::class, 'search'])->name('post.search');

//作成
Route::post('/post', [PostController::class, 'create'])->middleware('auth')->name('post.create');;
//詳細
Route::get('/post/{post}', [PostController::class, 'show'])->name('post.show');
//編集
Route::get('/post/{post}/edit', [PostController::class, 'edit'])->middleware('auth')->name('post.edit');
//更新
Route::post('/post/{post}', [PostController::class, 'update'])->middleware('auth')->name('post.update');
//削除
Route::delete('/post/{post}', [PostController::class, 'destroy'])->middleware('auth')->name('post.destroy');

/***************************************************
 * user
 ***************************************************/
//ユーザー情報
Route::get('/user/{user}', [UserController::class, 'user']);
//ユーザー編集
Route::get('/user/{user}/edit', [UserController::class, 'edit']);
//ユーザー更新
Route::post('/user/{user}', [UserController::class, 'update']);

/***************************************************
 * like
 ***************************************************/
Route::put('/post/{post}/like', [LikeController::class, 'like'])->middleware('auth');
Route::delete('/post/{post}/like', [LikeController::class, 'unlike'])->middleware('auth');

/***************************************************
 * follow
 ***************************************************/
Route::put('/user/{user}/follow', [FollowController::class, 'follow'])->middleware('auth');
Route::delete('/user/{user}/follow', [FollowController::class, 'unfollow'])->middleware('auth');
