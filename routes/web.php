<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\CommentController;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

// Маршруты для постов
Route::resource('posts', PostController::class)->middleware('auth')->except(['index', 'show']);
Route::resource('posts', PostController::class)->only(['index', 'show']);

// Маршруты для подписок
Route::post('/api/subscribe/{userId}', [SubscriptionController::class, 'subscribe'])->middleware('auth');
Route::delete('/api/unsubscribe/{userId}', [SubscriptionController::class, 'unsubscribe'])->middleware('auth');
Route::get('/api/subscriptions', [SubscriptionController::class, 'index'])->middleware('auth');

// Маршруты для комментариев
Route::post('/api/posts/{postId}/comments', [CommentController::class, 'store'])->middleware('auth')->name('comments.store');
Route::delete('/api/comments/{id}', [CommentController::class, 'destroy'])->middleware('auth')->name('comments.destroy');
Route::post('/api/posts/{id}/rate', [PostController::class, 'rating'])->middleware('auth')->name('posts.rating');

Route::get('/', function (Request $request) {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'posts' => Post::where('is_private', false)->withCount('comments')->get(),
        'user' => Auth::user(),
        'isAuth' => $request->user() ? true : false
    ]);
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/api/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/api/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';