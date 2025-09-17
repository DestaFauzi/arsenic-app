<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectType;
use App\Models\User;
use App\Models\Finance;
use App\Models\Income; // Tambahkan import untuk Income model
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::with(['projectType', 'pic'])
            ->when(request('status'), function ($query, $status) {
                return $query->byStatus($status);
            })
            ->when(request('project_type'), function ($query, $projectType) {
                return $query->byProjectType($projectType);
            })
            ->when(request('search'), function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(10);

        $projectTypes = ProjectType::active()->get();
        // Update status options to use numeric values with descriptions
        $statuses = [
            1 => 'Planning',
            2 => 'On Progress',
            3 => 'Completed'
        ];

        return view('projects.index', compact('projects', 'projectTypes', 'statuses'));
    }

    public function create(): View
    {
        $projectTypes = ProjectType::active()->get();
        $projectManagers = User::projectManagers()->get();

        // Status options untuk dropdown
        $statuses = [
            1 => 'Planning',
            2 => 'On Progress',
            3 => 'Completed'
        ];

        return view('projects.create', compact('projectTypes', 'projectManagers', 'statuses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_type_id' => 'required|exists:project_types,id',
            'pic_user_id' => 'required|exists:users,id',
            // Update validation to use numeric status (1=planning, 2=on progress, 3=completed)
            'status' => ['nullable', Rule::in([1, 2, 3])],
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'budget' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0|max:100',
            'additional_info' => 'nullable|array'
        ]);

        // Verify PIC is actually a Project Manager
        $pic = User::find($validated['pic_user_id']);
        if (!$pic->hasRole('project_manager')) {
            return back()->withErrors(['pic_user_id' => 'Selected PIC must have Project Manager role.'])->withInput();
        }

        // Set default status to Planning (1) if not provided
        if (!isset($validated['status']) || empty($validated['status'])) {
            $validated['status'] = 1; // Default Planning
        }

        // Set default tax percentage if not provided
        if (!isset($validated['tax'])) {
            $validated['tax'] = 10; // Default tax 10%
        }

        // Calculate tax amount and grand total if budget is provided
        if (isset($validated['budget']) && $validated['budget'] > 0) {
            $validated['tax_percentage'] = $validated['tax'];
            $validated['tax_amount'] = ($validated['budget'] * $validated['tax']) / 100;
            $validated['grand_total'] = $validated['budget'] + $validated['tax_amount'];
        }

        $project = Project::create($validated);

        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil dibuat!');
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_type_id' => 'required|exists:project_types,id',
            'pic_user_id' => 'required|exists:users,id',
            // Update validation to use numeric status (1=planning, 2=on progress, 3=completed)
            'status' => ['required', Rule::in([1, 2, 3])],
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'budget' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0|max:100',
            'additional_info' => 'nullable|array'
        ]);

        // Verify PIC is actually a Project Manager
        $pic = User::find($validated['pic_user_id']);
        if (!$pic->hasRole('project_manager')) {
            return back()->withErrors(['pic_user_id' => 'Selected PIC must have Project Manager role.'])->withInput();
        }

        // Calculate tax amount and grand total if budget is provided
        if (isset($validated['budget']) && $validated['budget'] > 0) {
            $validated['tax_percentage'] = $validated['tax'] ?? $project->tax_percentage ?? 10;
            $validated['tax_amount'] = ($validated['budget'] * $validated['tax_percentage']) / 100;
            $validated['grand_total'] = $validated['budget'] + $validated['tax_amount'];
        }

        // Check if status changed to Completed (3)
        $oldStatus = $project->status;
        $newStatus = $validated['status'];

        $project->update($validated);

        // Auto-create invoice when status changes to Completed (3)
        if ($oldStatus != 3 && $newStatus == 3) {
            $this->createInvoiceForCompletedProject($project);
        }

        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil diupdate!');
    }

    /**
     * Create invoice entry when project is completed
     */
    private function createInvoiceForCompletedProject(Project $project): void
    {
        Income::create([
            'project_id' => $project->id,
            'amount' => $project->budget ?? 0,
            'tax_percentage' => $project->tax_percentage ?? 0,
            'tax_amount' => $project->tax_amount ?? 0,
            'grand_total' => $project->grand_total ?? ($project->budget ?? 0),
            'source' => 'project_completion',
            'description' => 'Invoice otomatis untuk project completed: ' . $project->name,
            'received_date' => now(),
            'invoice_number' => 'INV-' . $project->id . '-' . now()->format('Ymd'),
            'status' => Income::STATUS_NEED_ACCOUNTING_APPROVAL, // Default status 1 - DIPERBAIKI
            'created_by' => auth()->id()
        ]);
    }

    public function show(Project $project): View
    {
        $project->load(['projectType', 'pic']);
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project): View
    {
        $projectTypes = ProjectType::active()->get();
        $projectManagers = User::projectManagers()->get();

        return view('projects.edit', compact('project', 'projectTypes', 'projectManagers'));
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil dihapus!');
    }
}
