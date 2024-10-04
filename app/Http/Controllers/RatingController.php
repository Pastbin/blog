<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request, Post $post)
    {
        $this->authorize('rate', $post);

        $ratingValue = $request->input('value');
        if (!is_numeric($ratingValue) || $ratingValue < 1 || $ratingValue > 5) {
            return response()->json(['error' => 'Invalid rating value'], 422);
        }

        Rating::create([
            'user_id' => auth()->id(),
            'post_id' => $post->id,
            'value' => $ratingValue,
        ]);

        $post->calculateAverageRating();

        return response()->json(['message' => 'Rating added successfully', 'average_rating' => $post->rating]);
    }

    public function show(Post $post)
    {
        //
    }

    public function edit(Post $post)
    {
        //
    }

    public function update(Request $request, Post $post)
    {
        //
    }

    public function destroy(Post $post)
    {
        //
    }
}