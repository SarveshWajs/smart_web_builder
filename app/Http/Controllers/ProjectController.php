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

    // Only fetch themes/components for admin
    $themes = [];
    $components = [];
    if (auth()->check() && auth()->user()->is_admin) {
        $themes = \App\Models\Theme::latest()->get();
        $components = \App\Models\Component::latest()->get();
    }

    return view('projects.dashboard', compact('projects', 'themes', 'components'));
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
        'user_id' => auth()->id(),
    ]);

    $project->components()->attach($request->component_ids);

    // Combine HTML, CSS, and JS
    $bodyHtml = '';
    $css = $project->theme->css;
    $js = $project->theme->js ?? '';

    foreach ($project->components as $component) {
        $bodyHtml .= $component->html . "\n";
        $css .= "\n" . $component->css;
        if (!empty($component->js)) {
            $js .= "\n" . $component->js;
        }
    }

    // Wrap with HTML structure and link to style.css and script.js
    $html = <<<HTML
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style.css">
</head>
<body>
$bodyHtml

<script src="script.js"></script>
</body>
</html>
HTML;

    // Save to file system
    $dir = public_path("storage/projects/project_{$project->id}");
    File::ensureDirectoryExists($dir);

    file_put_contents("$dir/index.html", $html);
    file_put_contents("$dir/style.css", $css);
    file_put_contents("$dir/script.js", $js); // <-- Add this line

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
    public function download($id)
{
    $project = Project::findOrFail($id);

    $folder = public_path("storage/projects/project_{$project->id}");

    if (!file_exists($folder)) {
        abort(404, 'Project files not found.');
    }

    $zipFile = tempnam(sys_get_temp_dir(), 'project_') . '.zip';
    $zip = new \ZipArchive;

    if ($zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
        $files = ['index.html', 'style.css', 'script.js'];

        foreach ($files as $file) {
            $filePath = $folder . '/' . $file;
            if (file_exists($filePath)) {
                $zip->addFile($filePath, $file); // Add with file name only
            }
        }

        $zip->close();
    } else {
        abort(500, 'Could not create ZIP archive.');
    }

    return response()->download($zipFile, $project->name . '.zip')->deleteFileAfterSend(true);
}


public function favorite(Project $project)
{
    auth()->user()->favorites()->attach($project->id);
    return back();
}

public function unfavorite(Project $project)
{
    auth()->user()->favorites()->detach($project->id);
    return back();
}
public function favorites()
{
    $projects = auth()->user()->favorites()->with('theme')->latest()->get();
    return view('projects.favorite', compact('projects'));
}

public function myTemplates()
{
    $projects = auth()->user()->projects()->with('theme')->latest()->get();
    return view('projects.template', compact('projects'));
}
public function show($id)
{
    $project = Project::findOrFail($id);
    return view('projects.show', compact('project'));
}

}
