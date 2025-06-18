<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Category;

class SeoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (!method_exists($response, 'content')) {
            return $response;
        }

        $content = $response->content();

        // Default meta tags
        $title = 'The District Hamilton - Tapas + Bar';
        $description = 'Experience exceptional Spanish cuisine at The District Hamilton - Tapas + Bar. Fresh local ingredients, innovative cuisine, and elegant atmosphere in the heart of Hamilton.';
        
        // Route-specific meta tags
        switch ($request->path()) {
            case '/':
                $title = 'The District Hamilton - Tapas + Bar';
                $description = 'Welcome to District Hamilton, where culinary excellence meets elegant atmosphere. Experience our innovative menu featuring local ingredients and exceptional wine pairings.';
                break;
            case 'menu':
                $title = 'Menu | District Hamilton - Innovative Spanish Cuisine';
                $description = 'Explore our carefully curated menu featuring seasonal ingredients, innovative dishes, and exceptional wine pairings at District Hamilton.';
                break;
            case 'about':
                $title = 'About Us | District Hamilton - Our Story & Philosophy';
                $description = 'Learn about District Hamilton\'s commitment to culinary excellence, our talented team, and our philosophy of using fresh, local ingredients.';
                break;
            case 'contact':
                $title = 'Contact Us | District Hamilton - Reservations & Inquiries';
                $description = 'Make a reservation or contact District Hamilton for special events, catering inquiries, or general information. We look forward to serving you.';
                break;
            case 'events':
                $title = 'Private Events | District Hamilton - Memorable Celebrations';
                $description = 'Host your special event at District Hamilton. From intimate gatherings to corporate events, we offer customized menus and exceptional service.';
                break;
        }

        // Add meta tags if they don't exist
        $content = preg_replace(
            '/<title>.*?<\/title>/i',
            "<title>$title</title>",
            $content
        );

        // Add meta description
        if (!preg_match('/<meta name="description".*?>/', $content)) {
            $content = str_replace(
                '<head>',
                '<head>' . PHP_EOL . '    <meta name="description" content="' . $description . '">',
                $content
            );
        }

        // Add other important meta tags
        $metaTags = '
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="' . $title . '">
    <meta property="og:description" content="' . $description . '">
    <meta property="og:type" content="website">
    <meta property="og:url" content="' . $request->url() . '">
    <meta property="og:site_name" content="District Hamilton">
    <link rel="canonical" href="' . $request->url() . '">';

        // Add Restaurant Schema with OpenTable integration
        $restaurantSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Restaurant',
            'name' => 'The District - Tapas + Bar Hamilton',
            'image' => url('/images/restaurant.jpg'),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => '61 Barton St E',
                'addressLocality' => 'Hamilton',
                'addressRegion' => 'ON',
                'postalCode' => 'L8L 2V7',
                'addressCountry' => 'CA'
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => '43.26356',
                'longitude' => '-79.8633'
            ],
            'url' => url('/'),
            'telephone' => '+1-905-522-2580',
            'servesCuisine' => 'Tapas, Spanish, Bar',
            'priceRange' => '$$',
            'openingHours' => [
                'Tue-Friday 17:00-22:00',
                'Sat 11:00-22:00',
                'Sun 11:00-21:00'
            ],
            'acceptsReservations' => 'True',
            'potentialAction' => [
                '@type' => 'ReserveAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => 'https://www.opentable.ca/restref/client/?rid=1431862&restref=1431862&lang=en-CA',
                    'inLanguage' => 'en-CA',
                    'actionPlatform' => [
                        'http://schema.org/DesktopWebPlatform',
                        'http://schema.org/MobileWebPlatform',
                        'http://schema.org/IOSPlatform',
                        'http://schema.org/AndroidPlatform'
                    ]
                ],
                'result' => [
                    '@type' => 'Reservation',
                    'name' => 'Reserve a table at The District Hamilton'
                ]
            ]
        ];

        // Add Menu Items Schema if on menu page
        if ($request->path() === 'menu') {
            $menuItems = MenuItem::with('category')->get();
            $menu = [
                '@context' => 'https://schema.org',
                '@type' => 'Menu',
                'name' => 'District Hamilton Menu',
                'hasMenuSection' => []
            ];

            $categories = Category::with('menuItems')->get();
            foreach ($categories as $category) {
                $section = [
                    '@type' => 'MenuSection',
                    'name' => $category->name,
                    'hasMenuItem' => []
                ];

                foreach ($category->menuItems as $item) {
                    $section['hasMenuItem'][] = [
                        '@type' => 'MenuItem',
                        'name' => $item->name,
                        'description' => $item->description,
                        'price' => '$' . number_format($item->price, 2),
                        'image' => $item->image ? url($item->image) : null
                    ];
                }

                $menu['hasMenuSection'][] = $section;
            }

            $restaurantSchema['hasMenu'] = $menu;
        }

        // Add Schema to page
        $schemaScript = '<script type="application/ld+json">' . json_encode($restaurantSchema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . '</script>';
        
        $content = str_replace(
            '</head>',
            $metaTags . PHP_EOL . $schemaScript . PHP_EOL . '</head>',
            $content
        );

        $response->setContent($content);
        return $response;
    }
} 