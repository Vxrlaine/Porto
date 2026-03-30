<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommissionController extends Controller
{
    /**
     * Display a listing of commissions.
     */
    public function index(Request $request)
    {
        $query = Commission::query()->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by client name or email
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('client_name', 'like', '%' . $request->search . '%')
                    ->orWhere('client_email', 'like', '%' . $request->search . '%');
            });
        }

        $commissions = $query->paginate(15);
        return view('admin.commissions.index', compact('commissions'));
    }

    /**
     * Display the specified commission.
     */
    public function show(Commission $commission)
    {
        return view('admin.commissions.show', compact('commission'));
    }

    /**
     * Update the status of a commission.
     */
    public function updateStatus(Request $request, Commission $commission)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,reviewing,accepted,in_progress,completed,cancelled,rejected'],
            'admin_notes' => ['nullable', 'string'],
        ]);

        $commission->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? $commission->admin_notes,
        ]);

        return back()->with('success', 'Commission status updated successfully.');
    }

    /**
     * Assign a commission to a user.
     */
    public function assign(Request $request, Commission $commission)
    {
        $validated = $request->validate([
            'assigned_to' => ['nullable', 'exists:users,id'],
        ]);

        $commission->update(['assigned_to' => $validated['assigned_to'] ?? null]);

        return back()->with('success', 'Commission assignment updated successfully.');
    }

    /**
     * Remove the specified commission.
     */
    public function destroy(Commission $commission)
    {
        // Delete reference images if they exist
        if ($commission->reference_images) {
            foreach ($commission->reference_images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $commission->delete();

        return redirect()->route('admin.commissions.index')
            ->with('success', 'Commission deleted successfully.');
    }
}
