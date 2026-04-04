@extends('admin.layout')

@section('title', $project->id ? 'Edit Project' : 'Create Project')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.projects.index') }}" class="text-[#0d328f] hover:underline flex items-center mb-4">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Projects
    </a>
    <h1 class="text-3xl font-bold text-gray-800">{{ $project->id ? 'Edit Project' : 'Create New Project' }}</h1>
</div>

<div class="bg-white rounded-xl shadow p-6 max-w-3xl">
    <form action="{{ $project->id ? route('admin.projects.update', $project) : route('admin.projects.store') }}" 
          method="POST" enctype="multipart/form-data" id="projectForm">
        @csrf
        @if($project->id)
            @method('PUT')
        @endif

        <div class="space-y-6">
            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Title <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title', $project->title) }}"
                       required
                       maxlength="255"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0d328f] focus:border-transparent outline-none transition @error('title') border-red-500 @enderror"
                       placeholder="Project Title">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0d328f] focus:border-transparent outline-none transition @error('description') border-red-500 @enderror"
                          placeholder="Describe the project...">{{ old('description', $project->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image -->
            <div>
                <label for="image_path" class="block text-sm font-medium text-gray-700 mb-2">
                    Project Image
                </label>
                @if($project->image_path)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $project->image_path) }}"
                             alt="Current Image"
                             class="w-48 h-48 object-cover rounded-lg">
                    </div>
                @endif
                <input type="file"
                       id="image_path"
                       name="image_path"
                       accept="image/*"
                       onchange="previewImage(this)"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0d328f] focus:border-transparent outline-none transition @error('image_path') border-red-500 @enderror">
                <p class="mt-1 text-sm text-gray-500">Max size: 2MB. Accepted: JPG, PNG, GIF, WebP</p>
                @error('image_path')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <div id="imagePreview" class="mt-3 hidden">
                    <img id="preview" src="" alt="Preview" class="w-48 h-48 object-cover rounded-lg">
                </div>
            </div>

            <!-- Client Name & Completion Date -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="client_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Client Name
                    </label>
                    <input type="text" 
                           id="client_name" 
                           name="client_name" 
                           value="{{ old('client_name', $project->client_name) }}"
                           maxlength="255"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0d328f] focus:border-transparent outline-none transition @error('client_name') border-red-500 @enderror"
                           placeholder="Client Name">
                    @error('client_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="completion_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Completion Date
                    </label>
                    <input type="date" 
                           id="completion_date" 
                           name="completion_date" 
                           value="{{ old('completion_date', $project->completion_date?->format('Y-m-d')) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0d328f] focus:border-transparent outline-none transition @error('completion_date') border-red-500 @enderror">
                    @error('completion_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Project URL -->
            <div>
                <label for="project_url" class="block text-sm font-medium text-gray-700 mb-2">
                    Project URL
                </label>
                <input type="url" 
                       id="project_url" 
                       name="project_url" 
                       value="{{ old('project_url', $project->project_url) }}"
                       maxlength="255"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0d328f] focus:border-transparent outline-none transition @error('project_url') border-red-500 @enderror"
                       placeholder="https://example.com/project">
                @error('project_url')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Order & Active -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                        Display Order <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="order" 
                           name="order" 
                           value="{{ old('order', $project->order ?? 0) }}"
                           required
                           min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0d328f] focus:border-transparent outline-none transition @error('order') border-red-500 @enderror">
                    @error('order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center mt-6">
                    <input type="checkbox" 
                           id="is_active" 
                           name="is_active" 
                           value="1"
                           {{ old('is_active', $project->is_active ?? true) ? 'checked' : '' }}
                           class="w-5 h-5 text-[#0d328f] border-gray-300 rounded focus:ring-[#0d328f]">
                    <label for="is_active" class="ml-3 text-sm text-gray-700">
                        Active (visible on website)
                    </label>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex space-x-4 mt-8 pt-6 border-t">
            <button type="submit" 
                    class="bg-[#0d328f] text-white px-8 py-3 rounded-lg font-medium hover:bg-[#0a256b] transition shadow-lg">
                {{ $project->id ? 'Update Project' : 'Create Project' }}
            </button>
            <a href="{{ route('admin.projects.index') }}" 
               class="px-8 py-3 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition">
                Cancel
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('preview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Form validation
document.getElementById('projectForm').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const order = document.getElementById('order').value;
    
    if (!title) {
        e.preventDefault();
        alert('Please enter a project title.');
        document.getElementById('title').focus();
        return false;
    }
    
    if (order < 0) {
        e.preventDefault();
        alert('Order must be 0 or greater.');
        document.getElementById('order').focus();
        return false;
    }
});
</script>
@endpush
@endsection
