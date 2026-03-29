<?php

namespace App\Http\Controllers;

use App\Models\PortfolioImage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $portfolioImages = PortfolioImage::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('welcome', compact('portfolioImages'));
    }
}
