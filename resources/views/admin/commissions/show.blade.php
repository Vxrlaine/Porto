@extends('admin.layout')

@section('title', 'Commission Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.commissions.index') }}" class="text-[#0d328f] hover:underline flex items-center mb-4">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Commissions
    </a>
    <h1 class="text-3xl font-bold text-gray-800">Commission Details</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Commission Info -->
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Commission Information</h2>
                <span class="px-4 py-2 text-sm font-medium rounded-full
                    @if($commission->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($commission->status === 'reviewing') bg-blue-100 text-blue-800
                    @elseif($commission->status === 'accepted') bg-green-100 text-green-800
                    @elseif($commission->status === 'in_progress') bg-purple-100 text-purple-800
                    @elseif($commission->status === 'completed') bg-emerald-100 text-emerald-800
                    @elseif($commission->status === 'cancelled') bg-gray-100 text-gray-800
                    @elseif($commission->status === 'rejected') bg-red-100 text-red-800
                    @endif
                ">
                    {{ ucfirst(str_replace('_', ' ', $commission->status)) }}
                </span>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="text-sm text-gray-500">Description</label>
                    <p class="text-gray-800 whitespace-pre-wrap">{{ $commission->description }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-500">Character Type</label>
                        <p class="text-gray-800">{{ $commission->character_type ?? 'Not specified' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Character Count</label>
                        <p class="text-gray-800">{{ $commission->character_count }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-500">Budget</label>
                        <p class="text-gray-800">
                            @if($commission->budget)
                                ${{ number_format($commission->budget, 2) }}
                            @else
                                Not specified
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Deadline</label>
                        <p class="text-gray-800">
                            @if($commission->deadline)
                                {{ $commission->deadline->format('F d, Y') }}
                            @else
                                Not specified
                            @endif
                        </p>
                    </div>
                </div>

                @if($commission->reference_images && count($commission->reference_images) > 0)
                <div>
                    <label class="text-sm text-gray-500 mb-2 block">Reference Images</label>
                    <div class="grid grid-cols-3 gap-3">
                        @foreach($commission->reference_images as $image)
                            <a href="{{ asset('storage/' . $image) }}" target="_blank" class="block">
                                <img src="{{ asset('storage/' . $image) }}" 
                                     alt="Reference" 
                                     class="w-full h-32 object-cover rounded-lg hover:opacity-75 transition">
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Admin Notes -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Admin Notes</h2>
            <form action="{{ route('admin.commissions.update-status', $commission) }}" method="POST">
                @csrf
                @method('PATCH')
                <textarea name="admin_notes" 
                          rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0d328f] focus:border-transparent outline-none transition"
                          placeholder="Add internal notes about this commission...">{{ old('admin_notes', $commission->admin_notes) }}</textarea>
                <button type="submit" 
                        class="mt-3 bg-[#0d328f] text-white px-6 py-2 rounded-lg font-medium hover:bg-[#0a256b] transition">
                    Save Notes
                </button>
            </form>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Client Info -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Client Information</h2>
            <div class="space-y-3">
                <div>
                    <label class="text-sm text-gray-500">Name</label>
                    <p class="text-gray-800 font-medium">{{ $commission->client_name }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">Email</label>
                    <p class="text-gray-800">{{ $commission->client_email }}</p>
                </div>
                @if($commission->client_discord)
                <div>
                    <label class="text-sm text-gray-500">Discord</label>
                    <p class="text-gray-800">{{ $commission->client_discord }}</p>
                </div>
                @endif
                <div>
                    <label class="text-sm text-gray-500">Created At</label>
                    <p class="text-gray-800">{{ $commission->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">Updated At</label>
                    <p class="text-gray-800">{{ $commission->updated_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Update Status -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Update Status</h2>
            <form action="{{ route('admin.commissions.update-status', $commission) }}" method="POST">
                @csrf
                @method('PATCH')
                <select name="status" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0d328f] focus:border-transparent outline-none mb-4">
                    <option value="pending" {{ $commission->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="reviewing" {{ $commission->status === 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                    <option value="accepted" {{ $commission->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                    <option value="in_progress" {{ $commission->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ $commission->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $commission->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="rejected" {{ $commission->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                <button type="submit" 
                        class="w-full bg-[#0d328f] text-white px-6 py-3 rounded-lg font-medium hover:bg-[#0a256b] transition">
                    Update Status
                </button>
            </form>
        </div>

        <!-- Assign To -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Assign To</h2>
            <form action="{{ route('admin.commissions.assign', $commission) }}" method="POST">
                @csrf
                <select name="assigned_to" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0d328f] focus:border-transparent outline-none mb-4">
                    <option value="">Unassigned</option>
                    @foreach(\App\Models\User::where('is_admin', true)->get() as $user)
                        <option value="{{ $user->id }}" {{ $commission->assigned_to == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" 
                        class="w-full bg-[#0d328f] text-white px-6 py-3 rounded-lg font-medium hover:bg-[#0a256b] transition">
                    Assign
                </button>
            </form>
            @if($commission->assignedUser)
            <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-500">Currently assigned to:</p>
                <p class="font-medium text-gray-800">{{ $commission->assignedUser->name }}</p>
            </div>
            @endif
        </div>

        <!-- Danger Zone -->
        <div class="bg-white rounded-xl shadow p-6 border border-red-200">
            <h2 class="text-xl font-semibold text-red-600 mb-4">Danger Zone</h2>
            <form action="{{ route('admin.commissions.destroy', $commission) }}" method="POST" 
                  onsubmit="return confirm('Are you sure you want to delete this commission? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="w-full bg-red-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-red-700 transition">
                    Delete Commission
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
