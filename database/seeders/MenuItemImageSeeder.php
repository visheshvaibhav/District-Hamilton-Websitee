<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class MenuItemImageSeeder extends Seeder
{
    protected $placeholderImages = [
        'appetizers' => [
            'https://images.unsplash.com/photo-1541014741259-de529411b96a?w=800', // Tapas
            'https://images.unsplash.com/photo-1541745537411-b8046dc6d66c?w=800', // Bruschetta
            'https://images.unsplash.com/photo-1608039829572-78524f79c4c7?w=800', // Calamari
        ],
        'main_courses' => [
            'https://images.unsplash.com/photo-1611599539392-0198d33c4c1e?w=800', // Paella
            'https://images.unsplash.com/photo-1598514983318-2f64f8f4796c?w=800', // Steak
            'https://images.unsplash.com/photo-1548943487-a2e4e43b4853?w=800', // Seafood
        ],
        'desserts' => [
            'https://images.unsplash.com/photo-1551024506-0bccd828d307?w=800', // Churros
            'https://images.unsplash.com/photo-1624353365286-3f8d62daad51?w=800', // Flan
            'https://images.unsplash.com/photo-1551106652-a5bcf4b29ab6?w=800', // Cake
        ],
        'drinks' => [
            'https://images.unsplash.com/photo-1536935338788-846bb9981813?w=800', // Sangria
            'https://images.unsplash.com/photo-1544145945-f90425340c7e?w=800', // Wine
            'https://images.unsplash.com/photo-1621873495884-845a939892d4?w=800', // Cocktails
        ]
    ];

    public function run()
    {
        $menuItems = MenuItem::all();
        
        foreach ($menuItems as $menuItem) {
            $category = $menuItem->category;
            $categoryKey = strtolower(str_replace(' ', '_', $category->name_en));
            
            if (isset($this->placeholderImages[$categoryKey])) {
                $images = $this->placeholderImages[$categoryKey];
                $randomImage = $images[array_rand($images)];
                
                try {
                    $response = Http::get($randomImage);
                    if ($response->successful()) {
                        $filename = 'menu-items/' . uniqid() . '.jpg';
                        Storage::disk('public')->put($filename, $response->body());
                        
                        $menuItem->update([
                            'image_path' => $filename
                        ]);
                    }
                } catch (\Exception $e) {
                    // Log error but continue with other items
                    \Log::error("Failed to download image for menu item {$menuItem->id}: " . $e->getMessage());
                }
            }
        }
    }
} 