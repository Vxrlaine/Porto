@extends('admin.layout')

@section('title', $skill->id ? 'Edit Skill' : 'Create Skill')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.skills.index') }}" class="text-[#0d328f] hover:underline flex items-center mb-4">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Skills
    </a>
    <h1 class="text-3xl font-bold text-gray-800">{{ $skill->id ? 'Edit Skill' : 'Create New Skill' }}</h1>
</div>

<div class="bg-white rounded-xl shadow p-6 max-w-2xl">
    <form action="{{ $skill->id ? route('admin.skills.update', $skill) : route('admin.skills.store') }}" 
          method="POST" id="skillForm">
        @csrf
        @if($skill->id)
            @method('PUT')
        @endif

        <div class="space-y-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Skill Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $skill->name) }}"
                       required
                       maxlength="255"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0d328f] focus:border-transparent outline-none transition @error('name') border-red-500 @enderror"
                       placeholder="e.g., Character Design, Digital Painting">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                    Category
                </label>
                <input type="text" 
                       id="category" 
                       name="category" 
                       value="{{ old('category', $skill->category) }}"
                       maxlength="100"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0d328f] focus:border-transparent outline-none transition @error('category') border-red-500 @enderror"
                       placeholder="e.g., Software, Technique, Style">
                <p class="mt-1 text-sm text-gray-500">Optional: Group similar skills together</p>
                @error('category')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Proficiency -->
            <div>
                <label for="proficiency" class="block text-sm font-medium text-gray-700 mb-2">
                    Proficiency Level <span class="text-red-500">*</span>
                </label>
                <div class="flex items-center space-x-4">
                    <input type="range" 
                           id="proficiency" 
                           name="proficiency" 
                           value="{{ old('proficiency', $skill->proficiency ?? 50) }}"
                           required
                           min="0"
                           max="100"
                           class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-[#0d328f]"
                           oninput="updateProficiencyValue(this.value)">
                    <span id="proficiencyValue" class="text-2xl font-bold text-[#0d328f] w-16 text-center">
                        {{ old('proficiency', $skill->proficiency ?? 50) }}%
                    </span>
                </div>
                <p class="mt-1 text-sm text-gray-500">0% = Beginner, 100% = Expert</p>
                @error('proficiency')
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
                           value="{{ old('order', $skill->order ?? 0) }}"
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
                           {{ old('is_active', $skill->is_active ?? true) ? 'checked' : '' }}
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
                {{ $skill->id ? 'Update Skill' : 'Create Skill' }}
            </button>
            <a href="{{ route('admin.skills.index') }}" 
               class="px-8 py-3 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition">
                Cancel
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
function updateProficiencyValue(value) {
    document.getElementById('proficiencyValue').textContent = value + '%';
}

// Form validation
document.getElementById('skillForm').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    const proficiency = document.getElementById('proficiency').value;
    const order = document.getElementById('order').value;
    
    if (!name) {
        e.preventDefault();
        alert('Please enter a skill name.');
        document.getElementById('name').focus();
        return false;
    }
    
    if (proficiency < 0 || proficiency > 100) {
        e.preventDefault();
        alert('Proficiency must be between 0 and 100.');
        document.getElementById('proficiency').focus();
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
