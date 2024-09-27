<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Project;
use App\Notifications\ProjectStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    private function uploadImage($file, $path = null)
    {
        $filename_image = $path . "/" . uniqid() . "." . $file->getClientOriginalExtension();
        \Illuminate\Support\Facades\Storage::disk('public')->put($filename_image, file_get_contents($file));
        return $filename_image;
    }

    public function index()
    {
        return Inertia::render('Projects/Index', [
            'projects' => Project::with('staff')->latest()->get()
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'staff_id' => 'required|exists:users,id',
                'status' => 'required|in:active,inactive,hold',
                'file' => 'nullable|file|mimes:jpg,png,jpeg,gif|max:2048',
            ]);

            $filePath = $request->file('file') ? $this->uploadImage($request->file('file'), 'projects') : null;

            $project = Project::create([
                'name' => $request->name,
                'description' => $request->description,
                'staff_id' => $request->staff_id,
                'status' => $request->status,
                'file_path' => $filePath,
            ]);

            // Notify admin about project creation
            $admin = User::where('is_admin', 1)->first();
            $message = 'A new project has been created.';
            $admin->notify(new ProjectStatusNotification($project, $message));

            return redirect()->route('projects')->with('success', 'Project created successfully!');
        }

        return Inertia::render('Projects/Create', [
            'staff' => User::all()
        ]);
    }

    public function update(Request $request, Project $project)
    {
        if ($request->isMethod('post')) {
            // Validate the incoming request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'staff_id' => 'required|exists:users,id',
                'status' => 'required|in:active,inactive,hold',
                'file' => 'nullable|file|mimes:jpg,png,jpeg,gif|max:2048'
            ]);

            if ($request->hasFile('file')) {
                if ($project->file_path && Storage::disk('public')->exists($project->file_path)) {
                    Storage::disk('public')->delete($project->file_path);
                }

                $validated['file_path'] = $this->uploadImage($request->file('file'), 'projects');
            }

            unset($validated['file']);

            if ($project->status != $validated['status']) {
                // Notify admin about status change
                $admin = User::where('is_admin', 1)->first();
                $message = 'The project status has been updated.';
                $admin->notify(new ProjectStatusNotification($project, $message));
            }
            $project->update($validated);

            return to_route('projects')->with('success', 'Project updated successfully.');
        }
        return Inertia::render('Projects/Edit', [
            'project' => $project,
            'staff' => User::all()
        ]);
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
        $deletedProjects = Project::onlyTrashed()->get();
        return Inertia::render('RecycleBin', ['projects' => $deletedProjects]);
    }

    public function restore(Request $request)
    {
        $projectIds = $request->input('projects');
        Project::onlyTrashed()->whereIn('id', $projectIds)->restore();

        return to_route('recycle-bin')->with('success', 'Projects restored successfully.');
    }
}
