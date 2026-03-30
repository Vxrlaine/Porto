@extends('admin.layout')

@section('title', 'Skills')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Skills</h1>
        <p class="text-gray-600 mt-1">Manage your skills and proficiencies</p>
    </div>
    <a href="{{ route('admin.skills.create') }}" 
       class="bg-[#0d328f] text-white px-6 py-3 rounded-lg font-medium hover:bg-[#0a256b] transition shadow-lg">
        + Add New Skill
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proficiency</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($skills as $skill)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                    {{ $skill->order }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <p class="font-medium text-gray-900">{{ $skill->name }}</p>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                    {{ $skill->category ?? '-' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                            <div class="bg-[#0d328f] h-2 rounded-full" style="width: {{ $skill->proficiency }}%"></div>
                        </div>
                        <span class="text-sm text-gray-600">{{ $skill->proficiency }}%</span>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-3 py-1 text-xs font-medium rounded-full {{ $skill->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $skill->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.skills.edit', $skill) }}" 
                           class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                        <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" class="inline" 
                              onsubmit="return confirm('Are you sure you want to delete this skill?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                    No skills found. <a href="{{ route('admin.skills.create') }}" class="text-[#0d328f] hover:underline">Create one</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($skills->hasPages())
<div class="mt-6">
    {{ $skills->links() }}
</div>
@endif
@endsection
