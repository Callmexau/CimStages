<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Structure;
use Illuminate\Http\Request;

class AdminStructureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $structures = Structure::all();
        return view('admin.structures.index', compact('structures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.structures.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'abbreviation' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        Structure::create($request->only('name', 'abbreviation', 'description'));

        return redirect()->route('admin.structures.index')
                         ->with('success', 'Structure créée avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $structure = Structure::findOrFail($id);
        return view('admin.structures.edit', compact('structure'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'abbreviation' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $structure = Structure::findOrFail($id);
        $structure->update($request->only('name', 'abbreviation', 'description'));

        return redirect()->route('admin.structures.index')
                         ->with('success', 'Structure mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $structure = Structure::findOrFail($id);
        $structure->delete();

        return redirect()->route('admin.structures.index')
                         ->with('success', 'Structure supprimée avec succès.');
    }
}
