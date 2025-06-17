<?php

namespace App\Http\Controllers;

use App\Models\Component;
use Illuminate\Http\Request;

class ComponentController extends Controller
{
    /**
     * Display a listing of the components.
     */
    public function index()
    {
        $components = Component::latest()->paginate(10);
        return view('component.index', compact('components'));
    }

    /**
     * Show the form for creating a new component.
     */
    public function create()
    {
        return view('component.create');
    }

    /**
     * Store a newly created component in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'html' => 'required|string',
            'css' => 'nullable|string',
        ]);

        Component::create([
            'name' => $request->name,
            'html' => $request->html,
            'css' => $request->css,
        ]);

        return redirect()->route('component.index')->with('success', 'Component created successfully.');
    }

    /**
     * Display the specified component.
     */
    public function show(Component $component)
    {
        return view('component.show', compact('component'));
    }

    /**
     * Show the form for editing the specified component.
     */
    public function edit(Component $component)
    {
        return view('component.edit', compact('component'));
    }

    /**
     * Update the specified component in storage.
     */
    public function update(Request $request, Component $component)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'html' => 'required|string',
            'css' => 'nullable|string',
        ]);

        $component->update([
            'name' => $request->name,
            'html' => $request->html,
            'css' => $request->css,
        ]);

        return redirect()->route('component.index')->with('success', 'Component updated successfully.');
    }

    /**
     * Remove the specified component from storage.
     */
    public function destroy(Component $component)
    {
        $component->delete();
        return redirect()->route('component.index')->with('success', 'Component deleted successfully.');
    }
public function toggle(Component $component)
{
    $component->status = !$component->status;
    $component->save();
    return back()->with('status', 'Component status updated!');
}

}
