<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectApiController extends Controller
{
    protected ProjectRepository $repository;

    public function __construct(ProjectRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of projects.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $activeOnly = $request->boolean('active_only', true);
        $perPage = $request->integer('per_page', 15);

        $projects = $this->repository->getFilteredProjects($search, $activeOnly, $perPage);

        return ProjectResource::collection($projects);
    }

    /**
     * Display the specified project.
     */
    public function show(int $id)
    {
        $project = $this->repository->findOrFail($id);
        return new ProjectResource($project);
    }

    /**
     * Store a newly created project.
     */
    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $request->file('image_path')->store('projects', 'public');
        }

        $project = $this->repository->create($validated);

        return new ProjectResource($project);
    }

    /**
     * Update the specified project.
     */
    public function update(UpdateProjectRequest $request, int $id)
    {
        $project = $this->repository->findOrFail($id);
        $validated = $request->validated();

        if ($request->hasFile('image_path')) {
            if ($project->image_path) {
                Storage::disk('public')->delete($project->image_path);
            }
            $validated['image_path'] = $request->file('image_path')->store('projects', 'public');
        }

        $project->update($validated);

        return new ProjectResource($project);
    }

    /**
     * Remove the specified project.
     */
    public function destroy(int $id)
    {
        $project = $this->repository->findOrFail($id);

        if ($project->image_path) {
            Storage::disk('public')->delete($project->image_path);
        }

        $project->delete();

        return response()->json(['message' => 'Project deleted successfully.']);
    }
}
