<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'value' => 'required|integer|min:1|max:5',
        ]);

        // Создаем или обновляем рейтинг
        Rating::updateOrCreate(
            ['user_id' => Auth::id(), 'post_id' => $post->id],
            ['value' => $request->input('value')]
        );

        // Пересчитываем средний рейтинг поста
        $post->calculateAverageRating();

        return redirect()->back()->with('success', 'Рейтинг обновлен');
    }
}
