<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function __construct(protected ApiService $api) {}

    public function index()
    {
        $response   = $this->api->getCategories();
        $categories = $response->successful() ? $response->json() : [];
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $response = $this->api->createCategoria($request->only('nom', 'descripcio'));

        if ($response->successful()) {
            return redirect()->route('categories.index')
                ->with('success', 'Categoria creada correctament');
        }

        return back()->withErrors($response->json('errors', []))->withInput();
    }

    public function show(int $category)
    {
        $response  = $this->api->getCategoria($category);
        $categoria = $response->successful() ? $response->json() : null;
        return view('categories.show', compact('categoria'));
    }

    public function edit(int $category)
    {
        $response  = $this->api->getCategoria($category);
        $categoria = $response->successful() ? $response->json() : null;
        return view('categories.edit', compact('categoria'));
    }

    public function update(Request $request, int $category)
    {
        $response = $this->api->updateCategoria($category, $request->only('nom', 'descripcio'));

        if ($response->successful()) {
            return redirect()->route('categories.index')
                ->with('success', 'Categoria actualitzada correctament');
        }

        return back()->withErrors($response->json('errors', []))->withInput();
    }

    public function destroy(int $category)
    {
        $this->api->deleteCategoria($category);
        return redirect()->route('categories.index')
            ->with('success', 'Categoria eliminada correctament');
    }
}
