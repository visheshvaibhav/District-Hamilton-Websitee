<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        // Get featured menu items for the homepage
        $featuredItems = MenuItem::where('is_featured', true)
            ->where('is_visible', true)
            ->where('is_available', true)
            ->orderBy('sort_order')
            ->take(3)
            ->get();
            
        // If there are not enough featured items, just get the latest menu items
        if ($featuredItems->count() < 3) {
            $additionalItems = MenuItem::where('is_visible', true)
                ->where('is_available', true)
                ->whereNotIn('id', $featuredItems->pluck('id')->toArray())
                ->orderBy('created_at', 'desc')
                ->take(3 - $featuredItems->count())
                ->get();
                
            $featuredItems = $featuredItems->merge($additionalItems);
        }
        
        return view('home.index', compact('featuredItems'));
    }
} 