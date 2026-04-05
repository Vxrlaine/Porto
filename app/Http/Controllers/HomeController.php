<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\PortfolioImage;
use App\Models\Skill;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get active projects for carousel display
        $projects = Project::where('is_active', true)
            ->orderBy('order')
            ->get();

        // Get active skills for skills section
        $skills = Skill::where('is_active', true)
            ->orderBy('order')
            ->get();

        // Also get portfolio images if they exist (for backward compatibility)
        $portfolioImages = PortfolioImage::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('welcome', compact('projects', 'portfolioImages', 'skills'));
    }
}
