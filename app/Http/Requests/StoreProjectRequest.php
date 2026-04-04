<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'client_name' => 'nullable|string|max:255',
            'completion_date' => 'nullable|date|before_or_equal:today',
            'project_url' => 'nullable|url|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
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
            'title.required' => 'Project title is required.',
            'title.max' => 'Project title cannot exceed 255 characters.',
            'image_path.image' => 'The uploaded file must be an image.',
            'image_path.mimes' => 'Image must be one of the following types: jpeg, png, jpg, gif, webp.',
            'image_path.max' => 'Image size cannot exceed 2MB.',
            'completion_date.before_or_equal' => 'Completion date cannot be in the future.',
            'project_url.url' => 'Please enter a valid project URL.',
            'order.integer' => 'Order must be a number.',
            'order.min' => 'Order cannot be negative.',
        ];
    }
}
