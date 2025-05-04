<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    // Listar todas las etiquetas
    public function index()
    {
        return Tag::with('posts')->get();
    }

    // Crear una nueva etiqueta
    public function store(Request $request)
    {
        // Validación del nombre del tag
        $request->validate([
            'name' => 'required|string|unique:tags,name',
        ]);

        // Crear el tag
        $tag = Tag::create([
            'name' => $request->name,
        ]);

        return response()->json($tag, 201);
    }

    // Mostrar una etiqueta específica
    public function show(Tag $tag)
    {
        return $tag->load('posts');
    }

    // Actualizar una etiqueta
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|string|unique:tags,name,' . $tag->id,
        ]);

        $tag->update($request->only('name'));

        return response()->json($tag);
    }

    // Eliminar una etiqueta
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response()->json(null, 204);
    }
}
