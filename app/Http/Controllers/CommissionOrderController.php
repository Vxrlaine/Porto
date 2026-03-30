<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommissionOrderController extends Controller
{
    /**
     * Show the commission order form.
     */
    public function create()
    {
        return view('commissions.create');
    }

    /**
     * Store a new commission order.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'client_email' => ['required', 'email', 'max:255'],
            'client_discord' => ['nullable', 'string', 'max:100'],
            'description' => ['required', 'string', 'min:50'],
            'character_type' => ['nullable', 'string', 'max:100'],
            'character_count' => ['required', 'integer', 'min:1', 'max:10'],
            'reference_images.*' => ['nullable', 'image', 'max:5120'],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'deadline' => ['nullable', 'date', 'after:today'],
        ], [
            'description.min' => 'Please provide a more detailed description (at least 50 characters).',
            'character_count.max' => 'Maximum 10 characters per commission.',
            'deadline.after' => 'The deadline must be in the future.',
        ]);

        $data = $validated;
        $data['status'] = 'pending';

        // Handle reference images upload
        $imagePaths = [];
        if ($request->hasFile('reference_images')) {
            foreach ($request->file('reference_images') as $image) {
                $imagePaths[] = $image->store('commission-references', 'public');
            }
        }
        $data['reference_images'] = !empty($imagePaths) ? $imagePaths : null;

        Commission::create($data);

        return redirect()->route('commissions.create')
            ->with('success', 'Your commission order has been submitted successfully! We will contact you soon.');
    }
}
