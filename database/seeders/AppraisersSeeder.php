<?php
namespace Database\Seeders;
use App\Models\Appraiser;
use App\Models\User;
use Illuminate\Database\Seeder;

class AppraisersSeeder extends Seeder
{
    public function run()
    {
        $appraisers = [
            [
                'email' => 'ahmad.expert@example.com',
                'experience_years' => 10,
                'license_number' => 'LIC-1234',
                'specialty' => 'Residential Apartment Valuation',
                'availability' => json_encode([
                    'saturday' => ['09:00-13:00', '14:00-17:00'],
                    'sunday' => ['09:00-13:00', '14:00-17:00'],
                    'monday' => ['09:00-13:00', '14:00-17:00'],
                    'tuesday' => ['09:00-13:00', '14:00-17:00'],
                    'wednesday' => ['09:00-13:00', '14:00-17:00'],
                    'thursday' => ['09:00-13:00'],
                    'friday' => [],
                ]),
                'hourly_rate' => 50,
                'rating' => 4.8
            ],
            [
                'email' => 'sara.engineer@example.com',
                'experience_years' => 7,
                'license_number' => 'LIC-5678',
                'specialty' => 'Villas and Mansions Valuation',
                'availability' => json_encode([
                    'saturday' => ['10:00-14:00', '15:00-18:00'],
                    'sunday' => ['10:00-14:00', '15:00-18:00'],
                    'monday' => ['10:00-14:00', '15:00-18:00'],
                    'tuesday' => ['10:00-14:00', '15:00-18:00'],
                    'wednesday' => ['10:00-14:00'],
                    'thursday' => [],
                    'friday' => [],
                ]),
                'hourly_rate' => 65,
                'rating' => 4.7
            ],
            [
                'email' => 'mohammad.realestate@example.com',
                'experience_years' => 12,
                'license_number' => 'LIC-9012',
                'specialty' => 'Land and Commercial Projects Valuation',
                'availability' => json_encode([
                    'saturday' => ['09:00-16:00'],
                    'sunday' => ['09:00-16:00'],
                    'monday' => ['09:00-16:00'],
                    'tuesday' => ['09:00-16:00'],
                    'wednesday' => ['09:00-16:00'],
                    'thursday' => ['09:00-13:00'],
                    'friday' => [],
                ]),
                'hourly_rate' => 75,
                'rating' => 4.9
            ],
            [
                'email' => 'layla.expert@example.com',
                'experience_years' => 5,
                'license_number' => 'LIC-3456',
                'specialty' => 'Investment Apartments and Residential Complexes',
                'availability' => json_encode([
                    'saturday' => ['11:00-15:00', '16:00-19:00'],
                    'sunday' => ['11:00-15:00', '16:00-19:00'],
                    'monday' => ['11:00-15:00', '16:00-19:00'],
                    'tuesday' => ['11:00-15:00', '16:00-19:00'],
                    'wednesday' => ['11:00-15:00'],
                    'thursday' => [],
                    'friday' => [],
                ]),
                'hourly_rate' => 45,
                'rating' => 4.6
            ],
        ];

        // Create appraisers for the existing users
        foreach ($appraisers as $appraiserData) {
            $user = User::where('email', $appraiserData['email'])->first();
            
            if ($user) {
                Appraiser::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'experience_years' => $appraiserData['experience_years'],
                        'license_number' => $appraiserData['license_number'],
                        'specialty' => $appraiserData['specialty'],
                        'availability' => $appraiserData['availability'],
                        'hourly_rate' => $appraiserData['hourly_rate'],
                        'rating' => $appraiserData['rating']
                    ]
                );
            }
        }
    }
}