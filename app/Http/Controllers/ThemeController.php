<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function index()
    {
        $themes = Theme::all();
        return view('themes.index', compact('themes'));
    }

    public function create()
    {
        return view('themes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'custom_css' => 'nullable|string',
        ]);

        Theme::create([
            'name' => $request->name,
            'css' => $request->custom_css, // Save CSS to DB
        ]);

        return redirect()->route('themes.index')->with('success', 'Theme created successfully.');
    }

    public function edit(Theme $theme)
    {
        return view('themes.edit', compact('theme'));
    }

    public function update(Request $request, Theme $theme)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'custom_css' => 'nullable|string',
    ]);

    $theme->update([
        'name' => $request->name,
        'css' => $request->custom_css ?? '', // Default to empty string
    ]);

    return redirect()->route('themes.index')->with('success', 'Theme updated successfully.');
}

    public function destroy(Theme $theme)
    {
        $theme->delete();
        return redirect()->route('themes.index')->with('success', 'Theme deleted successfully.');
    }

    public function toggle(Theme $theme)
    {
        $theme->status = !$theme->status;
        $theme->save();
        return back()->with('status', 'Theme status updated!');
    }
}
