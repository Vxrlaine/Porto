<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $stats = [
            'total_projects' => Project::count(),
            'total_skills' => Skill::count(),
            'total_commissions' => Commission::count(),
            'pending_commissions' => Commission::where('status', 'pending')->count(),
            'active_commissions' => Commission::whereIn('status', ['accepted', 'in_progress'])->count(),
            'completed_commissions' => Commission::where('status', 'completed')->count(),
        ];

        $recentCommissions = Commission::with('assignedUser')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentCommissions'));
    }
}
