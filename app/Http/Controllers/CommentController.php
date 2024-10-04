<?php

// app/Http/Controllers/CommentController.php
namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
    use AuthorizesRequests;

    public function show($id)
    {
        $comments = Comment::where('post_id', $id)->get();
        return response()->json($comments);
    }

    public function store(Request $request, $postId)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $postId,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Комментарий добавлен');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $this->authorize('delete', $comment);

        $comment->delete();
        return response(['message' => 'Комментарий удалён']);
    }
}
