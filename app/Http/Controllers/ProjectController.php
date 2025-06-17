<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Theme;
use App\Models\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProjectController extends Controller
{
    // Show dashboard with all projects
    public function index()
    {
       $projects = Project::with('theme')->latest()->get();
        return view('projects.dashboard', compact('projects'));
    }

    // Show form to create a new project
    public function create()
    {
        $themes = Theme::all();
        $components = Component::all();
        return view('projects.create', compact('themes', 'components'));
    }

    // Store new project and generate files
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'theme_id' => 'required|exists:themes,id',
            'component_ids' => 'required|array',
        ]);

        // Save project with user ownership
        $project = Project::create([
            'name' => $request->name,
            'theme_id' => $request->theme_id,

        ]);

        $project->components()->attach($request->component_ids);

        // Combine HTML and CSS
        $html = '';
        $css = $project->theme->css;

        foreach ($project->components as $component) {
            $html .= $component->html . "\n";
            $css .= "\n" . $component->css;
        }

        // Save to file system
        $dir = public_path("storage/projects/project_{$project->id}");
        File::ensureDirectoryExists($dir);

        file_put_contents("$dir/index.html", $html);
        file_put_contents("$dir/style.css", $css);

        return redirect()->route('projects.preview', $project->id);
    }

    // Preview a generated project
    public function preview(Project $project)
    {
        return view('projects.preview', compact('project'));
    }

    // Optional: Delete a project
    public function destroy(Project $project)
    {


        $dir = public_path("storage/projects/project_{$project->id}");
        if (File::exists($dir)) {
            File::deleteDirectory($dir);
        }

        $project->delete();

        return redirect()->route('projects.index')->with('status', 'Project deleted successfully!');
    }
}
