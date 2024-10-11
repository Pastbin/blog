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
        $posts = $query->withCount('comments')->paginate(8);

        return Inertia::render('Post/AllPosts', [
            'posts' => $posts->items(),
            'paginationLinks' => $posts->linkCollection(),
        ]);
    }

    // Создаем форму для создания нового поста
    public function create()
    {
        return Inertia::render('Post/AddPost');
    }

    // Показываем пост по ID
    public function show(Post $post)
    {
        $post->load('comments.user');
        return Inertia::render('Post/PostOne', ['post' => $post]);
    }

    // Создаем новый пост
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required',
            'is_private' => 'boolean',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'tags' => 'string|max:255',
        ]);

        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'body' => $request->body,
            'is_private' => $request->is_private ?? false,
            'tags' => $request->input('tags', ''),
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('images', $imageName);
            $post->image = 'images/' . $imageName;
            $post->save();
        }

        return redirect()->route('posts.index');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return Inertia::render('Post/PostEdit', ['post' => $post]);
    }

    // Редактируем пост
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('updateTags', $post);
        $post->update($request->all());

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $post->image = 'images/' . $imageName;
            $post->save();
        }

        return redirect()->back()->with('success', 'Пост обновлен');
    }

    // Удаляем пост
    public function destroy(Post $post)
    {
        if (Auth::user()->is_admin) {
            $post->delete();
            return response()->json(['message' => 'Пост удалён']);
        } else {
            return response()->json(['message' => 'Доступ запрещён'], 403);
        }
    }
}
