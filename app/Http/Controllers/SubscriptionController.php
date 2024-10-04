<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    // Подписываемся на пользователя
    public function subscribe($userId)
    {
        $subscription = Subscription::create([
            'user_id' => Auth::id(),
            'subscribed_to_user_id' => $userId,
        ]);

        return redirect()->back()->with('success', 'Вы подписались на пользователя');
    }

    // Отписываемся от пользователя
    public function unsubscribe($userId)
    {
        Subscription::where('user_id', Auth::id())
            ->where('subscribed_to_user_id', $userId)
            ->delete();

        return redirect()->back()->with('success', 'Вы отписались от пользователя');
    }

    // Получаем список подписок пользователя
    public function index()
    {
        $subscriptions = Subscription::where('user_id', Auth::id())->get();
        return response()->json($subscriptions);
    }
}
