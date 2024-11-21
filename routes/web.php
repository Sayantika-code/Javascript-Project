<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [BaseController::class, 'index'])->name('home');

Route::post('/posts', [BaseController::class, 'store'])->name('posts.store');
Route::post('/post/update/{id}', [BaseController::class, 'postUpdate'])->name('post.update');
Route::post('/post/delete/{id}', [BaseController::class, 'postDelete'])->name('post.delete');
Route::post('/comments/add', [BaseController::class, 'addComment'])->name('comment.store');
Route::post('/comments/edit/{id}', [BaseController::class, 'editComment'])->name('comment.edit');
Route::post('/comments/delete/{id}', [BaseController::class, 'deleteComment'])->name('comment.delete');



Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.now');
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('verify.login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Admin view routes  
Route::middleware(['auth'])->group(function () {    
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard'); 
    Route::get('/admin/posts', [AdminController::class, 'post'])->name('admin.posts');       
    Route::get('/admin/posts/edit', [AdminController::class, 'editPosts'])->name('edit.posts');       
    Route::post('/admin/posts/delete/{id}', [AdminController::class, 'deletePosts'])->name('delete.posts');
    Route::get('/admin/comments', [AdminController::class, 'comment'])->name('admin.comments');   
    Route::post('/admin/comments/delete/{id}', [AdminController::class, 'deleteComments'])->name('delete.comments');
    Route::get('/admin/bloggers', [AdminController::class, 'user'])->name('admin.bloggers');   
    Route::post('/admin/bloggers/inactive/{id}', [AdminController::class, 'incactiveUser'])->name('inactive.bloggers');
});
