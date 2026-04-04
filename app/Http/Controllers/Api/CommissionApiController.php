<?php

namespace App\Http\Controllers\Api;

use App\Events\CommissionCreated;
use App\Events\CommissionStatusChanged;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommissionRequest;
use App\Http\Requests\UpdateCommissionStatusRequest;
use App\Http\Resources\CommissionResource;
use App\Models\Commission;
use App\Repositories\CommissionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommissionApiController extends Controller
{
    protected CommissionRepository $repository;

    public function __construct(CommissionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of commissions (admin only).
     */
    public function index(Request $request)
    {
        $status = $request->input('status');
        $search = $request->input('search');
        $perPage = $request->integer('per_page', 15);

        $query = Commission::query()->orderBy('created_at', 'desc');

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%")
                  ->orWhere('client_email', 'like', "%{$search}%");
            });
        }

        $commissions = $query->paginate($perPage);

        return CommissionResource::collection($commissions);
    }

    /**
     * Display the specified commission (admin only).
     */
    public function show(int $id)
    {
        $commission = $this->repository->findOrFail($id);
        return new CommissionResource($commission);
    }

    /**
     * Store a new commission (public).
     */
    public function store(StoreCommissionRequest $request)
    {
        $validated = $request->validated();
        $validated['status'] = 'pending';

        if ($request->hasFile('reference_images')) {
            $validated['reference_images'] = collect($request->file('reference_images'))
                ->map(fn($file) => $file->store('commission-references', 'public'))
                ->toArray();
        }

        $commission = Commission::create($validated);

        event(new CommissionCreated($commission));

        return response()->json([
            'message' => 'Commission created successfully.',
            'data' => new CommissionResource($commission),
        ], 201);
    }

    /**
     * Update commission status (admin only).
     */
    public function updateStatus(UpdateCommissionStatusRequest $request, int $id)
    {
        $commission = $this->repository->findOrFail($id);
        $validated = $request->validated();
        $oldStatus = $commission->status;

        $commission->update($validated);

        event(new CommissionStatusChanged($commission, $oldStatus, $validated['status']));

        return new CommissionResource($commission);
    }

    /**
     * Assign commission to user (admin only).
     */
    public function assign(Request $request, int $id)
    {
        $validated = $request->validate([
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $commission = $this->repository->findOrFail($id);
        $commission->update($validated);

        return new CommissionResource($commission);
    }

    /**
     * Delete commission (admin only).
     */
    public function destroy(int $id)
    {
        $commission = $this->repository->findOrFail($id);

        if ($commission->reference_images) {
            foreach ($commission->reference_images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $commission->delete();

        return response()->json(['message' => 'Commission deleted successfully.']);
    }
}
