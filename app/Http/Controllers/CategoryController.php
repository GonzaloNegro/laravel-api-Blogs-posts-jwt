<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Listar todas las categorías
    public function index()
    {
        return Category::with('posts')->get();
    }

    // Crear una nueva categoría
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name',
        ]);        

        $category = Category::create($request->only('name'));

        return response()->json($category, 201);
    }

    // Mostrar una categoría específica
    public function show(Category $category)
    {
        return $category->load('posts');
    }

    // Actualizar una categoría
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name,' . $category->id,
        ]);

        $category->update($request->only('name'));

        return response()->json($category);
    }

    // Eliminar una categoría
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(null, 204);
    }
}
