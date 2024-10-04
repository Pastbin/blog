<?php
// app/Http/Controllers/PostController.php
namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Rating;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Inertia\Inertia;

class PostController extends Controller
{
    use AuthorizesRequests;

    // Показываем все публичные посты
    public function index(Request $request)
    {
        $query = Post::where('is_private', false);

        // Получаем параметры сортировки из URL
        $sortBy = $request->input('sort_by', 'created_at'); // Поле сортировки (по умолчанию по дате)
        $order = $request->input('order', 'desc'); // Направление сортировки (по умолчанию по убыванию)

        // Проверяем корректность полей для сортировки
        if (in_array($sortBy, ['rating', 'created_at'])) {
            $query->orderBy($sortBy, $order);
        }

        // Пагинация
        $posts = $query->paginate(12);



        return Inertia::render('Post/AllPosts', [
            'posts' => $posts->items(),
            'paginationLinks' => $posts->linkCollection(),
        ]);
    }



    // Создаем форму для создания нового поста
    public function create()
    {
        $tags = Tag::all();
        return Inertia::render('Post/AddPost', ['tags' => $tags]);
    }

    // Показываем пост по ID
    public function show($id)
    {
        $post = Post::with('tags')->findOrFail($id);
        $comments = Comment::where('post_id', $id)->with('user')->get();
        return Inertia::render('Post/PostOne', ['post' => $post, 'comments' => $comments]);
    }

    // Создаем новый пост
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required',
            'is_private' => 'boolean',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'tags' => 'array',
        ]);

        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'body' => $request->body,
            'is_private' => $request->is_private ?? false,
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('images', $imageName);
            $post->image = 'images/' . $imageName;
            $post->save();
        }

        if ($request->has('tags')) {
            $post->tags()->attach($request->input('tags'));
        }

        return redirect()->route('posts.index');
    }

    // Редактируем пост
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('update', $post);

        $post->update($request->all());

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $post->image = 'images/' . $imageName;
            $post->save();
        }

        if ($request->has('tags')) {
            $post->tags()->sync($request->input('tags'));
        }

        return response()->json($post);
    }

    // Удаляем пост
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('delete', $post);

        $post->delete();
        return response()->json(['message' => 'Пост удален']);
    }

    public function rating(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('rate', $post);

        $ratingValue = $request->input('value');
        if (!is_numeric($ratingValue) || $ratingValue < 1 || $ratingValue > 5) {
            return response()->json(['error' => 'Invalid rating value'], 422);
        }

        Rating::create([
            'user_id' => Auth::id(),
            'post_id' => $id,
            'value' => $ratingValue,
        ]);

        $post->calculateAverageRating();

        return response()->json(['message' => 'Rating added successfully', 'average_rating' => $post->rating]);
    }
}
