<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;
use App\Models\Area;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some random areas to associate with testimonials
        $areas = Area::inRandomOrder()->take(5)->get();

        $testimonials = [
            [
                'name' => 'Ahmad Hassan',
                'position' => 'Business Owner',
                'content' => 'Finding our family home was made so much easier through this platform. The search filters helped us narrow down exactly what we were looking for, and the neighborhood information was spot on. We couldn\'t be happier with our new home!',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Layla Mahmoud',
                'position' => 'Marketing Director',
                'content' => 'As a first-time homebuyer, I was nervous about the entire process. This website not only helped me find the perfect apartment but also guided me through each step with their resources and customer support. I highly recommend it to anyone looking for property in Jordan.',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Omar Al-Qasim',
                'position' => 'Doctor',
                'content' => 'I was looking for an investment property, and this site had the most comprehensive options. The neighborhood analytics and price history helped me make an informed decision. The property is now rented out with a great ROI!',
                'rating' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Rania Khalil',
                'position' => 'Architect',
                'content' => 'The detailed property descriptions and high-quality photos were exactly what I needed. I could easily compare features across different listings and make my decision without wasting time on viewings that didn\'t meet my criteria.',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Karim Nasser',
                'position' => 'Software Engineer',
                'content' => 'The mobile app made my property search convenient and efficient. I could set alerts for new listings and was able to schedule viewings directly through the platform. My experience from search to purchase was smooth and hassle-free.',
                'rating' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $index => $testimonialData) {
            // Assign a random area to each testimonial
            if ($areas->isNotEmpty() && $index < count($areas)) {
                $testimonialData['area_id'] = $areas[$index]->id;
            }

            Testimonial::create($testimonialData);
        }

        // Create a couple of inactive testimonials to demonstrate the approval process
        Testimonial::create([
            'name' => 'Sarah Ahmed',
            'position' => 'Teacher',
            'content' => 'I recently moved to Amman and needed to find an apartment quickly. This website made the process so smooth. The property was exactly as described, and the agent was professional and helpful.',
            'rating' => 5,
            'is_active' => false,
            'area_id' => $areas->isNotEmpty() ? $areas->random()->id : null,
        ]);

        Testimonial::create([
            'name' => 'Mohammed Al-Farsi',
            'position' => 'Financial Analyst',
            'content' => 'The property I found through this site was a perfect match for my needs. The search filters were accurate, and I appreciated the transparent pricing information.',
            'rating' => 3,
            'is_active' => false,
            'area_id' => $areas->isNotEmpty() ? $areas->random()->id : null,
        ]);
    }
}