<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Public form
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client_discord' => 'nullable|string|max:255',
            'description' => 'required|string',
            'character_type' => 'nullable|string|max:255',
            'character_count' => 'nullable|integer|min:1|max:50',
            'reference_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'budget' => 'nullable|numeric|min:0',
            'deadline' => 'nullable|date|after:today',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'client_name.required' => 'Your name is required.',
            'client_email.required' => 'Your email is required.',
            'client_email.email' => 'Please provide a valid email address.',
            'description.required' => 'Please describe your commission request.',
            'character_count.integer' => 'Character count must be a number.',
            'character_count.min' => 'You must have at least 1 character.',
            'character_count.max' => 'Maximum 50 characters allowed.',
            'reference_images.*.image' => 'All reference files must be images.',
            'reference_images.*.max' => 'Each reference image cannot exceed 5MB.',
            'budget.numeric' => 'Budget must be a number.',
            'budget.min' => 'Budget cannot be negative.',
            'deadline.after' => 'Deadline must be in the future.',
        ];
    }
}
