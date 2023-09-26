<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\CategoriesController;



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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// this is route group for all route accsessable only bylogin user/authenticated users
Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'index'])->name('index');

    // thisroute will serve view>user>create.blade.php
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    // This route will save a post
    Route::post('/post/store', [PostController::class, 'store'])->name('post.store');
    // this route willsurve views>users>post>show.blade.php
    Route::get('/post/{id}/show', [PostController::class, 'show'])->name('post.show');
    // this route will surve views>users>posts>edit.blade.php
    Route::get('/post/{id}/edit', [PostController::class, 'edit'])->name('post.edit');
    //This route will update a post
    Route::patch('/post/{id}/update', [PostController::class, 'update'])->name('post.update');
    //    This route  will delete the post
    Route::delete('/post/{id}/destroy', [PostController::class, 'destroy'])->name('post.destroy');

    //This route will store a commnets
    Route::post('/comment/{post_id}/store', [CommentController::class, 'store'])->name('comment.store');

    // This route will delate the commnet
    Route::delete('/comment/{id}/destroy', [CommentController::class, 'destroy'])->name('comment.destroy');

    // This route will serve the views>users>profile>show.blade.php
    Route::get('/profile/{id}/show', [ProfileController::class, 'show'])->name('profile.show');

    // This routen will serve the views>users>profile>edit.blade.php
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    //This route will update a user infomation
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    //This route will reset a user password
    Route::patch('/profile/resetpassword', [ProfileController::class, 'resetpassword'])->name('profile.resetpassword');



    // this route will surve views>users>profile>followers.blade.php
    Route::get('/profile/{id}/followers', [ProfileController::class, 'followers'])->name('profile.followers');
    // this route will surve views>users>profile>following.blade.php
    Route::get('/profile/{id}/following', [ProfileController::class, 'following'])->name('profile.following');

    // This route will store a like
    Route::post('/like/{post_id}/store', [LikeController::class, 'store'])->name('like.store');
    /**
     * HTTP REQUEST METHOD
     * to display a view file - use get(),  usually used in a anchor tag <a></a>
     * if the request is from a form - use post(),patch(), and delete
     *
     * post()
     * FORM structure
     * <form action="#" method="POST">
     *          @csrf
     *          <button type="submit" class="btn btn-sm shadow-none p-0">
     *              <i class="fa-regular fa-heart"></i>
     *          </button>
     * </form>
     *
     * patch()
     * FORM structure
     * <form action="#" method="POST">
     *          @csrf
     *          @method('PATCH')
     *          <button type="submit" class="btn btn-sm shadow-none p-0">
     *              <i class="fa-regular fa-heart"></i>
     *          </button>
     * </form>
     *
     * delete()
     * FORM structure
     * <form action="#" method="POST">
     *          @csrf
     *          @method('DELETE')
     *          <button type="submit" class="btn btn-sm shadow-none p-0">
     *              <i class="fa-regular fa-heart"></i>
     *          </button>
     * </form>
     */

    //    This route  will delete the like
    Route::delete('/like/{post_id}/destroy', [LikeController::class, 'destroy'])->name('like.destroy');

    // This route will store follow
    Route::post('/follow/{user_id}/store', [FollowController::class, 'store'])->name('follow.store');
    // This route  will delete the follow
    Route::delete('/follow/{post_id}/destroy', [FollowController::class, 'destroy'])->name('follow.destroy');

    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        // Users
        // URI : '/admin/users , ROUTE name: admin.users
        Route::get('/users', [UsersController::class, 'index'])->name('users');

        // This route  will deactivate the user
        Route::delete('/users/{id}/deactivate', [UsersController::class, 'deactivate'])->name('users.deactivate');
        // This route  will activate the user
        Route::patch('/users/{id}/activate', [UsersController::class, 'activate'])->name('users.activate');

        // Posts
        Route::get('/posts', [PostsController::class, 'index'])->name('posts');

        // This route  will hide the post
        Route::delete('/posts/{id}/hide', [PostsController::class, 'hide'])->name('posts.hide');
        // This route  will unhide the post
        Route::patch('/posts/{id}/unhide', [PostsController::class, 'unhide'])->name('posts.unhide');

        // Categories
        Route::get('/categories', [CategoriesController::class, 'index'])->name('categories');
        // Thie route will create a new category
        Route::post('/categories/store', [CategoriesController::class, 'store'])->name('categories.store');
        // This will update a new category
        Route::patch('/categories/{id}/update', [CategoriesController::class, 'update'])->name('categories.update');
        // This route  will delete the category
        Route::delete('/categories/{id}/destroy', [CategoriesController::class, 'destroy'])->name('categories.destroy');



    });
});
