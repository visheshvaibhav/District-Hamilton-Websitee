<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display the menu index page with all categories.
     */
    public function index()
    {
        // Get all visible categories with their menu items
        $categories = Category::where('is_visible', true)
            ->with(['menuItems' => function ($query) {
                $query->where('is_visible', true)
                    ->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get();
            
        return view('menu.index', compact('categories'));
    }
    
    /**
     * Display a specific category and its menu items.
     */
    public function category(Category $category)
    {
        // Ensure the category is visible
        if (!$category->is_visible) {
            abort(404);
        }
        
        // Load the menu items for this category
        $category->load(['menuItems' => function ($query) {
            $query->where('is_visible', true)
                ->orderBy('sort_order');
        }]);
        
        // Get all visible categories for the navigation
        $categories = Category::where('is_visible', true)
            ->orderBy('sort_order')
            ->get();
            
        return view('menu.category', compact('category', 'categories'));
    }
    
    /**
     * Display a specific menu item.
     */
    public function show(string $slug)
    {
        // Find the menu item by slug
        $item = MenuItem::where('slug', $slug)
            ->where('is_visible', true)
            ->with(['category', 'tags', 'addOns' => function ($query) {
                $query->where('is_available', true)
                    ->orderBy('sort_order');
            }])
            ->firstOrFail();
            
        // Get related items from the same category
        $relatedItems = MenuItem::where('category_id', $item->category_id)
            ->where('id', '!=', $item->id)
            ->where('is_visible', true)
            ->where('is_available', true)
            ->inRandomOrder()
            ->take(3)
            ->get();
            
        return view('menu.show', compact('item', 'relatedItems'));
    }
} 