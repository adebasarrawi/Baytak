<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Create profile-images directory if it doesn't exist
        if (!Storage::disk('public')->exists('profile-images')) {
            Storage::disk('public')->makeDirectory('profile-images');
        }

        // Add Blade directive for profile images
        Blade::directive('profileImage', function ($imagePath, $defaultImage = 'images/default-avatar.jpg') {
            return "<?php 
                if($imagePath && file_exists(public_path('storage/' . $imagePath))) {
                    echo asset('storage/' . $imagePath);
                } elseif($imagePath && Storage::disk('public')->exists($imagePath)) {
                    echo asset('storage/' . $imagePath);
                } else {
                    echo asset($defaultImage);
                }
            ?>";
        });

        // Add global helper function
        if (!function_exists('profileImageUrl')) {
            function profileImageUrl($imagePath, $defaultImage = 'images/default-avatar.jpg') {
                if ($imagePath) {
                    // Check if file exists in public/storage
                    if (file_exists(public_path('storage/' . $imagePath))) {
                        return asset('storage/' . $imagePath);
                    }
                    // Check if file exists in storage/app/public
                    if (Storage::disk('public')->exists($imagePath)) {
                        return asset('storage/' . $imagePath);
                    }
                }
                return asset($defaultImage);
            }
        }
    }

    
}