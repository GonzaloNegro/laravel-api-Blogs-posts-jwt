<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Mostrar todos los posts
    public function index()
    {
        return Post::with(['user', 'category', 'tags', 'comments'])->get();
    }

    // Crear un nuevo post
    public function store(Request $request)
    {
        // Validar los datos entrantes
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id', // Asegurarnos de que la categoría existe
            'tags' => 'array|exists:tags,id', // Validar que los tags son un array y que existen en la base de datos
        ]);
        
        // Obtener el usuario autenticado
        $user = Auth::user();
        
        // Crear el post asociado al usuario autenticado
        $post = new Post();
        $post->title = $validated['title'];
        $post->content = $validated['content'];
        $post->category_id = $validated['category_id'];
        $post->user_id = $user->id; // Asignar el user_id desde el usuario autenticado
        
        // Guardar el post en la base de datos
        $post->save();
        
        // Asociar los tags al post si existen
        if (isset($validated['tags'])) {
            $post->tags()->attach($validated['tags']);
        }
        
        // Devolver la respuesta con el post creado y los tags asociados
        return response()->json($post->load(['category', 'tags']), 201);
    }

    
    // Mostrar un post específico
    public function show(Post $post)
    {
        return $post->load(['user', 'category', 'tags', 'comments']);
    }

    // Actualizar un post
    public function update(Request $request, Post $post)
    {
        // Validar los datos entrantes
        $validated = $request->validate([
            'title' => 'string|max:255',
            'content' => 'string',
            'category_id' => 'exists:categories,id',
        ]);
    
        // Actualizar el post con los datos validados
        $post->update($validated);
    
        // Si hay tags, actualizarlos
        if (isset($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }
    
        // Devolver la respuesta con el post actualizado
        return response()->json($post->load(['category', 'tags']));
    }
    

    // Eliminar un post
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(null, 204);
    }
}
