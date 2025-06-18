<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MenuItem;
use App\Models\Category;
use Carbon\Carbon;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate the sitemap.xml file';

    public function handle()
    {
        $this->info('Generating sitemap...');

        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

        // Static pages
        $staticPages = [
            ['url' => '/', 'priority' => '1.0', 'changefreq' => 'daily'],
            ['url' => '/menu', 'priority' => '0.9', 'changefreq' => 'daily'],
            ['url' => '/about', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => '/contact', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => '/events', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => '/terms', 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['url' => '/privacy', 'priority' => '0.5', 'changefreq' => 'monthly'],
        ];

        foreach ($staticPages as $page) {
            $sitemap .= $this->generateUrlEntry(
                url($page['url']),
                $page['changefreq'],
                $page['priority']
            );
        }

        // Menu Categories
        $categories = Category::all();
        foreach ($categories as $category) {
            $sitemap .= $this->generateUrlEntry(
                url("/menu/category/{$category->slug}"),
                'weekly',
                '0.8'
            );
        }

        // Menu Items
        $menuItems = MenuItem::all();
        foreach ($menuItems as $item) {
            $sitemap .= $this->generateUrlEntry(
                url("/menu/item/{$item->slug}"),
                'weekly',
                '0.7'
            );
        }

        $sitemap .= '</urlset>';

        // Save the sitemap
        file_put_contents(public_path('sitemap.xml'), $sitemap);

        $this->info('Sitemap generated successfully!');
    }

    private function generateUrlEntry($url, $changefreq, $priority)
    {
        return "    <url>\n" .
               "        <loc>" . $url . "</loc>\n" .
               "        <lastmod>" . Carbon::now()->toAtomString() . "</lastmod>\n" .
               "        <changefreq>" . $changefreq . "</changefreq>\n" .
               "        <priority>" . $priority . "</priority>\n" .
               "    </url>\n";
    }
} 