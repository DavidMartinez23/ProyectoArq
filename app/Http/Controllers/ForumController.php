<?php

namespace App\Http\Controllers;

use App\Models\ForumComment;
use App\Models\ForumLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    public function index()
    {
        $comments = ForumComment::with(['user', 'replies.user'])
            ->whereNull('parent_id')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('forum.index', compact('comments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        ForumComment::create([
            'content' => $request->content,
            'user_id' => Auth::id(),
            'user_type' => Auth::user()->role
        ]);

        return redirect()->back()->with('success', 'Comentario publicado exitosamente');
    }

    public function reply(Request $request, ForumComment $comment)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        ForumComment::create([
            'content' => $request->content,
            'user_id' => Auth::id(),
            'user_type' => Auth::user()->role,
            'parent_id' => $comment->id
        ]);

        return redirect()->back()->with('success', 'Respuesta publicada exitosamente');
    }

    public function like(ForumComment $comment)
    {
        $like = ForumLike::where('user_id', Auth::id())
            ->where('forum_comment_id', $comment->id)
            ->first();

        if ($like) {
            $like->delete();
            $comment->decrement('likes_count');
        } else {
            ForumLike::create([
                'user_id' => Auth::id(),
                'forum_comment_id' => $comment->id
            ]);
            $comment->increment('likes_count');
        }

        return redirect()->back();
    }

    public function pin(ForumComment $comment)
    {
        if (Auth::user()->role !== 'teacher') {
            abort(403);
        }

        $comment->update(['is_pinned' => !$comment->is_pinned]);
        return redirect()->back();
    }

    public function destroy(ForumComment $comment)
    {
        if (Auth::id() !== $comment->user_id && Auth::user()->role !== 'teacher') {
            abort(403);
        }

        $comment->delete();
        return redirect()->back()->with('success', 'Comentario eliminado exitosamente');
    }
}