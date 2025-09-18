<?php

namespace App\Http\Controllers;

use App\Models\ProjectType;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $projectTypes = ProjectType::latest()->paginate(10);

        return view('project-types.index', compact('projectTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('project-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:project_types,name'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['boolean']
        ]);

        $validated['is_active'] = $request->has('is_active');

        ProjectType::create($validated);

        return redirect()->route('project-types.index')
            ->with('success', 'Project type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectType $projectType): View
    {
        $projectType->load('projects');

        return view('project-types.show', compact('projectType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectType $projectType): View
    {
        return view('project-types.edit', compact('projectType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectType $projectType): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:project_types,name,' . $projectType->id],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['boolean']
        ]);

        $validated['is_active'] = $request->has('is_active');

        $projectType->update($validated);

        return redirect()->route('project-types.index')
            ->with('success', 'Project type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectType $projectType): RedirectResponse
    {
        // Check if project type has associated projects
        if ($projectType->projects()->count() > 0) {
            return redirect()->route('project-types.index')
                ->with('error', 'Cannot delete project type that has associated projects.');
        }

        $projectType->delete();

        return redirect()->route('project-types.index')
            ->with('success', 'Project type deleted successfully.');
    }

    /**
     * Toggle the active status of the project type.
     */
    public function toggleStatus(ProjectType $projectType): RedirectResponse
    {
        $projectType->update([
            'is_active' => !$projectType->is_active
        ]);

        $status = $projectType->is_active ? 'activated' : 'deactivated';

        return redirect()->back()
            ->with('success', "Project type {$status} successfully.");
    }
}
