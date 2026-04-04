<?php

namespace App\Http\Controllers;

use App\Events\CommissionCreated;
use App\Http\Requests\StoreCommissionRequest;
use App\Models\Commission;
use Illuminate\Support\Facades\Storage;

class CommissionOrderController extends Controller
{
    /**
     * Show the commission order form.
     */
    public function create()
    {
        $user = auth()->user();
        
        return view('commissions.create', compact('user'));
    }

    /**
     * Store a new commission order.
     */
    public function store(StoreCommissionRequest $request)
    {
        $validated = $request->validated();
        $validated['status'] = 'pending';
        $validated['user_id'] = auth()->id();
        $validated['client_name'] = auth()->user()->name;
        $validated['client_email'] = auth()->user()->email;

        // Handle reference images upload
        $imagePaths = [];
        if ($request->hasFile('reference_images')) {
            foreach ($request->file('reference_images') as $image) {
                $imagePaths[] = $image->store('commission-references', 'public');
            }
        }
        $validated['reference_images'] = !empty($imagePaths) ? $imagePaths : null;

        $commission = Commission::create($validated);

        // Dispatch event for notifications
        event(new CommissionCreated($commission));

        return redirect()->route('commissions.create')
            ->with('success', 'Your commission order has been submitted successfully! We will contact you soon.');
    }
}
