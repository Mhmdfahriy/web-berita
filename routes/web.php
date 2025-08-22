<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->group(function() {
    Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.index');
    Route::get('/create', [App\Http\Controllers\Admin\HomeController::class, 'create'])->name('admin.create');
    Route::get('/edit/{id}', [App\Http\Controllers\Admin\HomeController::class, 'edit'])->name('admin.edit');
    Route::put('/update/{id}', [App\Http\Controllers\Admin\HomeController::class, 'update'])->name('admin.update');
    Route::delete('/destroy/{id}', [App\Http\Controllers\Admin\HomeController::class, 'destroy'])->name('admin.destroy');
    Route::post('/store', [App\Http\Controllers\Admin\HomeController::class, 'store'])->name('admin.store');
    Route::get('/show/{id}', [App\Http\Controllers\Admin\HomeController::class, 'show'])->name('admin.show');
});

Route::prefix('member')->group(function() {
    Route::get('/', [App\Http\Controllers\Member\HomeController::class, 'index'])->name('member.index');
    
    // Halaman detail artikel untuk member
    Route::get('/article/{id}', [App\Http\Controllers\Member\HomeController::class, 'show'])->name('member.article.show');
});

Route::post('/comments', [CommentController::class, 'store'])->name('comment.store');
Route::delete('/comments/destroy/{id}', [CommentController::class, 'destroy'])->name('comment.destroy');
Route::post('/comment/{comment}/reply', [CommentController::class, 'reply'])->name('comment.reply');