<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Http\Resources\SkillResource;
use App\Models\Skill;
use App\Repositories\SkillRepository;
use Illuminate\Http\Request;

class SkillApiController extends Controller
{
    protected SkillRepository $repository;

    public function __construct(SkillRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of skills.
     */
    public function index(Request $request)
    {
        $category = $request->input('category');
        $grouped = $request->boolean('grouped', false);

        if ($grouped) {
            $skills = $this->repository->getGroupedByCategory();
            return response()->json($skills->map(function ($items, $key) {
                return SkillResource::collection($items);
            }));
        }

        $skills = $this->repository->getActiveSkills($category);
        return SkillResource::collection($skills);
    }

    /**
     * Display the specified skill.
     */
    public function show(int $id)
    {
        $skill = $this->repository->findOrFail($id);
        return new SkillResource($skill);
    }

    /**
     * Store a newly created skill.
     */
    public function store(StoreSkillRequest $request)
    {
        $validated = $request->validated();
        $skill = $this->repository->create($validated);

        return new SkillResource($skill);
    }

    /**
     * Update the specified skill.
     */
    public function update(UpdateSkillRequest $request, int $id)
    {
        $skill = $this->repository->findOrFail($id);
        $validated = $request->validated();

        $skill->update($validated);

        return new SkillResource($skill);
    }

    /**
     * Remove the specified skill.
     */
    public function destroy(int $id)
    {
        $skill = $this->repository->findOrFail($id);
        $skill->delete();

        return response()->json(['message' => 'Skill deleted successfully.']);
    }
}
