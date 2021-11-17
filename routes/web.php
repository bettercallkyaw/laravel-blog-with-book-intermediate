<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;


Route::get('/',([PostController::class,'index']))->name('all.posts');
Route::resource('posts',PostController::class);
Route::resource('comments',CommentController::class);





Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
