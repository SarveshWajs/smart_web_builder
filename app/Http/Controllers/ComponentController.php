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
        'js' => 'nullable|string',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $imagePaths = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('components/images', 'public');
            $imagePaths[] = $path;
        }
    }

    // Replace placeholders in HTML with uploaded image URLs
    $html = $request->html;
    foreach ($imagePaths as $index => $path) {
        // Replace src="REPLACE_IMAGE_1", src="REPLACE_IMAGE_2", etc.
        $html = str_replace(
            'src="REPLACE_IMAGE_' . ($index + 1) . '"',
            'src="' . asset('storage/' . $path) . '"',
            $html
        );
    }

    Component::create([
        'name' => $request->name,
        'html' => $html,
        'css' => $request->css,
        'js' => $request->js,
        'images' => $imagePaths, // Make sure 'images' column is json/text in DB
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
        'js' => 'nullable|string',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $imagePaths = $component->images ?? [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('components/images', 'public');
            $imagePaths[] = $path;
        }
    }

    // Always replace placeholders with all images
    $html = $request->html;
    foreach ($imagePaths as $index => $path) {
        $html = str_replace(
            'src="REPLACE_IMAGE_' . ($index + 1) . '"',
            'src="' . asset('storage/' . $path) . '"',
            $html
        );
    }

    $component->update([
        'name' => $request->name,
        'html' => $html,
        'css' => $request->css,
        'js' => $request->js,
        'images' => $imagePaths,
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
public function deleteImage(Request $request, $id)
{
    $component = \App\Models\Component::findOrFail($id);
    $image = $request->query('image');

    if (!$image || !in_array($image, $component->images ?? [])) {
        return back()->withErrors(['Image not found.']);
    }

    // Remove from storage
    Storage::disk('public')->delete($image);

    // Remove from images array
    $images = array_filter($component->images, fn($img) => $img !== $image);
    $component->images = array_values($images);
    $component->save();

    return back()->with('success', 'Image deleted successfully.');
}

}
