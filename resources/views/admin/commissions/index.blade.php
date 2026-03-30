@extends('admin.layout')

@section('title', 'Commissions')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Commissions</h1>
        <p class="text-gray-600 mt-1">Manage commission orders</p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow p-4 mb-6">
    <form action="{{ route('admin.commissions.index') }}" method="GET" class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-64">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="Search by client name or email..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0d328f] focus:border-transparent outline-none">
        </div>
        <div>
            <select name="status" 
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0d328f] focus:border-transparent outline-none">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="reviewing" {{ request('status') == 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        <button type="submit" 
                class="bg-[#0d328f] text-white px-6 py-2 rounded-lg font-medium hover:bg-[#0a256b] transition">
            Filter
        </button>
        <a href="{{ route('admin.commissions.index') }}" 
           class="px-6 py-2 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition">
            Reset
        </a>
    </form>
</div>

<!-- Commissions Table -->
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Characters</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Budget</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($commissions as $commission)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div>
                        <p class="font-medium text-gray-900">{{ $commission->client_name }}</p>
                        <p class="text-sm text-gray-500">{{ $commission->client_email }}</p>
                        @if($commission->client_discord)
                            <p class="text-xs text-gray-400">Discord: {{ $commission->client_discord }}</p>
                        @endif
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                    {{ $commission->character_type ?? 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                    {{ $commission->character_count }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                    @if($commission->budget)
                        ${{ number_format($commission->budget, 2) }}
                    @else
                        -
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-3 py-1 text-xs font-medium rounded-full
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
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                    {{ $commission->created_at->format('M d, Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <a href="{{ route('admin.commissions.show', $commission) }}" 
                       class="text-[#0d328f] hover:text-blue-700 font-medium">
                        View
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                    No commissions found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($commissions->hasPages())
<div class="mt-6">
    {{ $commissions->links() }}
</div>
@endif
@endsection
