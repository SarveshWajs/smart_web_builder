<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Component;
use App\Models\Theme;

class GeneratorController extends Controller
{
    public function components()
    {
        return response()->json(Component::all());
    }

    public function themes()
    {
        return response()->json(Theme::all());
    }

    public function generate(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'theme_id' => 'required|exists:themes,id',
            'component_ids' => 'required|array',
        ]);

        $project = Project::create([
            'name' => $request->name,
            'theme_id' => $request->theme_id,
        ]);

        $project->components()->attach($request->component_ids);

        return response()->json(['project_id' => $project->id]);
    }

    public function project($id)
    {
        $project = Project::with(['theme', 'components'])->findOrFail($id);
        return response()->json($project);
    }

    public function html($id)
    {
        $project = Project::with(['theme', 'components'])->findOrFail($id);
        $html = '';

        foreach ($project->components as $component) {
            $html .= $component->html;
        }

        return response($html, 200)->header('Content-Type', 'text/html');
    }
}
