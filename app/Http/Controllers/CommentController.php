<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->user_id = auth()->id();
        $comment->course_id = $course->id;
        $comment->content = $validated['content'];
        $comment->save();

        return redirect()->back()->with('success', 'Comentario agregado correctamente.');
    }

    public function destroy(Comment $comment)
    {
        // Solo el autor del comentario o el profesor del curso pueden eliminar comentarios
        if ($comment->user_id !== auth()->id() && $comment->course->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'No tienes permiso para eliminar este comentario.');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Comentario eliminado correctamente.');
    }
}
