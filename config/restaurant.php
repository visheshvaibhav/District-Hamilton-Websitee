<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Restaurant Information
    |--------------------------------------------------------------------------
    |
    | This file is for storing basic information about the restaurant
    | such as name, address, contact information, and hours.
    |
    */

    'name' => env('RESTAURANT_NAME', 'The District Tapas Bar & Restaurant'),
    
    'address' => env('RESTAURANT_ADDRESS', '202 King St. East, Hamilton, ON L8N 1B5'),
    
    'phone' => env('RESTAURANT_PHONE', '(905) 525-0779'),
    
    'email' => env('RESTAURANT_EMAIL', 'info@district-tapas.com'),
    
    'website' => env('RESTAURANT_WEBSITE', 'https://district-tapas.com'),
    
    'hours' => [
        'monday' => ['12:00 PM - 10:00 PM'],
        'tuesday' => ['12:00 PM - 10:00 PM'],
        'wednesday' => ['12:00 PM - 10:00 PM'],
        'thursday' => ['12:00 PM - 10:00 PM'],
        'friday' => ['12:00 PM - 12:00 AM'],
        'saturday' => ['12:00 PM - 12:00 AM'],
        'sunday' => ['12:00 PM - 10:00 PM'],
    ],
    
    'social_media' => [
        'facebook' => env('RESTAURANT_FACEBOOK', 'https://facebook.com/districttapas'),
        'instagram' => env('RESTAURANT_INSTAGRAM', 'https://instagram.com/districttapas'),
        'twitter' => env('RESTAURANT_TWITTER', 'https://twitter.com/districttapas'),
    ],
    
    'order_notification_emails' => [
        env('ADMIN_EMAIL', 'admin@district-tapas.com'),
    ],

]; 