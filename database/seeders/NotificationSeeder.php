<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        // Clear existing notifications
        DB::table('notifications')->truncate();

        // Check if users exist
        if (DB::table('users')->count() == 0) {
            $this->command->error('No users found! Please seed users first.');
            return;
        }

        // Check if properties exist (for property-related notifications)
        $propertiesExist = DB::table('properties')->count() > 0;

        $notifications = [];
        $users = DB::table('users')->pluck('id');
        $now = Carbon::now();

        // Notification types and templates
        $notificationTypes = [
            'property_view' => [
                'title' => 'New Property View',
                'message' => 'Your property #{id} has been viewed by a potential buyer.'
            ],
            'price_reduction' => [
                'title' => 'Price Reduction Alert',
                'message' => 'A property matching your criteria has reduced its price.'
            ],
            'favorite_update' => [
                'title' => 'Favorite Update',
                'message' => 'A property in your favorites has been updated.'
            ],
            'system_alert' => [
                'title' => 'System Notification',
                'message' => 'Important system update: {message}'
            ],
            'message_received' => [
                'title' => 'New Message',
                'message' => 'You have received a new message from {sender}'
            ]
        ];

        foreach ($users as $userId) {
            // Create 3-5 notifications per user
            for ($i = 0; $i < rand(3, 5); $i++) {
                $type = array_rand($notificationTypes);
                $template = $notificationTypes[$type];
                
                $message = $template['message'];
                $referenceId = null;

                // Customize messages based on type
                switch ($type) {
                    case 'property_view':
                        if ($propertiesExist) {
                            $property = DB::table('properties')
                                ->where('user_id', $userId)
                                ->inRandomOrder()
                                ->first();
                            if ($property) {
                                $message = str_replace('{id}', $property->id, $message);
                                $referenceId = $property->id;
                            }
                        }
                        break;
                        
                    case 'price_reduction':
                    case 'favorite_update':
                        if ($propertiesExist) {
                            $property = DB::table('properties')->inRandomOrder()->first();
                            $referenceId = $property->id;
                        }
                        break;
                        
                    case 'system_alert':
                        $message = str_replace('{message}', 'Maintenance scheduled tonight', $message);
                        break;
                        
                    case 'message_received':
                        $sender = DB::table('users')->where('id', '!=', $userId)->inRandomOrder()->first();
                        if ($sender) {
                            $message = str_replace('{sender}', $sender->name, $message);
                        }
                        break;
                }

                $notifications[] = [
                    'user_id' => $userId,
                    'title' => $template['title'],
                    'message' => $message,
                    'type' => $type,
                    'reference_id' => $referenceId,
                    'is_read' => rand(0, 1), // Random read status
                    'created_at' => $now->subDays(rand(0, 30)), // Spread over last 30 days
                    'updated_at' => $now
                ];
            }
        }

        DB::table('notifications')->insert($notifications);
        $this->command->info('Successfully seeded notifications!');
    }
}