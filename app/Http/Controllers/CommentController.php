<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Crear un nuevo comentario
    public function store(Request $request)
    {
        // Validar los datos entrantes
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id', // Validar que el post exista
            'content' => 'required|string|max:500', // Validar que el contenido sea válido
        ]);

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Crear el comentario asociado al post y usuario
        $comment = Comment::create([
            'content' => $validated['content'],
            'user_id' => $user->id, // Asociar al usuario autenticado
            'post_id' => $validated['post_id'], // Asociar al post
        ]);

        // Devolver el comentario en formato JSON
        return response()->json($comment, 201); // Devolver el comentario recién creado
    }
}
