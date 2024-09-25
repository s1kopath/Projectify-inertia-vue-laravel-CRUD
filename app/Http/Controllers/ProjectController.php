<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    function uploadImage($file, $path = null)
    {
        $filename_image = uniqid() . "." . $file->getClientOriginalExtension();
        $file->move(public_path($path), $filename_image);
        return $path . '/' . $filename_image;
    }

    public function index()
    {
        $projects = Project::all();
        return Inertia::render('Projects', compact('projects'));
    }

    public function create()
    {
        return Inertia::render('NewProject');
    }

    public function store()
    {
        return Inertia::render('StoreProject');
    }

    public function show()
    {
        return Inertia::render('Project');
    }

    public function edit()
    {
        return Inertia::render('EditProject');
    }

    public function destroy(Project $project)
    {
        try {
            $project->delete();
            return back()->with('success', 'Project deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting the project');
        }
    }

    public function recycleBin()
    {
        return Inertia::render('RecycleBin');
    }
    public function restore()
    {
        return Inertia::render('RestoreProject');
    }

    public function forceDelete()
    {
        return Inertia::render('ForceDeleteProject');
    }

    public function restoreAll()
    {
        return Inertia::render('RestoreAllProject');
    }

    public function forceDeleteAll()
    {
        return Inertia::render('ForceDeleteAllProject');
    }

    public function showAll()
    {
        return Inertia::render('ShowAllProject');
    }

    public function search()
    {
        return Inertia::render('SearchProject');
    }
}
