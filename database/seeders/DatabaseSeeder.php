<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'mobile' => '+91 9876543210',
                'status' => 'active',
                'remove_copyright' => true,
                'remove_watermark' => true,
                'language' => 'en',
                'daily_download_limit_video' => 100,
                'daily_download_limit_design' => 200,
                'state' => 'Delhi',
                'city' => 'New Delhi',
                'party' => 'Central Committee',
                'designation_1' => 'System Administrator',
                'designation_2' => 'Head of Operations',
                'whatsapp' => '+919876543210',
                'facebook' => 'https://facebook.com/admin',
                'twitter' => '@admin_lead',
                'instagram' => '@admin_designera',
            ]
        );

        $sampleUsers = [
            [
                'name' => 'Sarah Jenkins',
                'email' => 'sarah.j@example.com',
                'mobile' => '+91 9823456781',
                'status' => 'active',
                'remove_copyright' => true,
                'remove_watermark' => true,
                'language' => 'en',
                'daily_download_limit_video' => 50,
                'daily_download_limit_design' => 100,
                'state' => 'Maharashtra',
                'city' => 'Mumbai',
                'party' => 'National Congress',
                'designation_1' => 'State Secretary',
                'designation_2' => 'Media Spokesperson',
                'whatsapp' => '+919823456781',
                'facebook' => 'https://facebook.com/sarah.jenkins',
                'twitter' => '@sarah_mumbai',
                'instagram' => '@sarah.j_official',
                'days' => 5,
                'verified' => true,
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'mchen@example.com',
                'mobile' => '+91 9712345672',
                'status' => 'active',
                'remove_copyright' => false,
                'remove_watermark' => true,
                'language' => 'en',
                'daily_download_limit_video' => 25,
                'daily_download_limit_design' => 50,
                'state' => 'Karnataka',
                'city' => 'Bengaluru',
                'party' => 'United Progressive',
                'designation_1' => 'General Secretary',
                'designation_2' => 'Tech & IT Cell Head',
                'whatsapp' => '+919712345672',
                'facebook' => 'https://facebook.com/mchen',
                'twitter' => '@mchen_tech',
                'instagram' => '@mchen_bengaluru',
                'days' => 4,
                'verified' => true,
            ],
            [
                'name' => 'Elena Rostova',
                'email' => 'elena.r@example.com',
                'mobile' => '+91 9654321873',
                'status' => 'inactive',
                'remove_copyright' => false,
                'remove_watermark' => false,
                'language' => 'hi',
                'daily_download_limit_video' => 10,
                'daily_download_limit_design' => 20,
                'state' => 'Uttar Pradesh',
                'city' => 'Lucknow',
                'party' => 'People Front',
                'designation_1' => 'Youth Wing President',
                'designation_2' => 'District Incharge',
                'whatsapp' => '+919654321873',
                'facebook' => null,
                'twitter' => '@elena_youth',
                'instagram' => '@elena_rostova',
                'days' => 3,
                'verified' => false,
            ],
            [
                'name' => 'David Kim',
                'email' => 'david.k@example.com',
                'mobile' => '+91 9834567894',
                'status' => 'active',
                'remove_copyright' => true,
                'remove_watermark' => false,
                'language' => 'gu',
                'daily_download_limit_video' => 30,
                'daily_download_limit_design' => 60,
                'state' => 'Gujarat',
                'city' => 'Ahmedabad',
                'party' => 'Democratic Alliance',
                'designation_1' => 'Treasurer',
                'designation_2' => 'Executive Member',
                'whatsapp' => '+919834567894',
                'facebook' => 'https://facebook.com/davidkim',
                'twitter' => null,
                'instagram' => '@david_ahmedabad',
                'days' => 2,
                'verified' => true,
            ],
            [
                'name' => 'Priya Sharma',
                'email' => 'priya.s@example.com',
                'mobile' => '+91 9911223345',
                'status' => 'active',
                'remove_copyright' => true,
                'remove_watermark' => true,
                'language' => 'hi',
                'daily_download_limit_video' => 40,
                'daily_download_limit_design' => 80,
                'state' => 'Rajasthan',
                'city' => 'Jaipur',
                'party' => 'Janata Morcha',
                'designation_1' => 'Vice President',
                'designation_2' => 'Cultural Affairs Incharge',
                'whatsapp' => '+919911223345',
                'facebook' => 'https://facebook.com/priyasharma',
                'twitter' => '@priya_jaipur',
                'instagram' => '@priya.sharma_official',
                'days' => 1,
                'verified' => true,
            ],
            [
                'name' => 'Alex Morgan',
                'email' => 'alex.m@example.com',
                'mobile' => '+91 9887766554',
                'status' => 'suspended',
                'remove_copyright' => false,
                'remove_watermark' => false,
                'language' => 'en',
                'daily_download_limit_video' => 0,
                'daily_download_limit_design' => 0,
                'state' => 'Delhi',
                'city' => 'South Delhi',
                'party' => 'Independent Coalition',
                'designation_1' => 'Campaign Manager',
                'designation_2' => null,
                'whatsapp' => '+919887766554',
                'facebook' => null,
                'twitter' => '@alex_campaign',
                'instagram' => null,
                'days' => 0,
                'verified' => false,
            ],
        ];

        foreach ($sampleUsers as $u) {
            User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'password' => bcrypt('password'),
                    'mobile' => $u['mobile'],
                    'status' => $u['status'],
                    'remove_copyright' => $u['remove_copyright'],
                    'remove_watermark' => $u['remove_watermark'],
                    'language' => $u['language'],
                    'daily_download_limit_video' => $u['daily_download_limit_video'],
                    'daily_download_limit_design' => $u['daily_download_limit_design'],
                    'state' => $u['state'],
                    'city' => $u['city'],
                    'party' => $u['party'],
                    'designation_1' => $u['designation_1'],
                    'designation_2' => $u['designation_2'],
                    'whatsapp' => $u['whatsapp'],
                    'facebook' => $u['facebook'],
                    'twitter' => $u['twitter'],
                    'instagram' => $u['instagram'],
                    'email_verified_at' => $u['verified'] ? now()->subDays($u['days']) : null,
                    'created_at' => now()->subDays($u['days']),
                    'updated_at' => now()->subDays($u['days']),
                ]
            );
        }

        // Seed Plans
        $plans = [
            [
                'id' => 1,
                'name' => '24 hrs Free Trial',
                'daily_limit_design' => 0,
                'daily_limit_video' => 0,
                'price' => 0,
                'duration_days' => 1,
                'status' => 'active',
                'created_at' => '2025-04-01 10:00:00',
                'updated_at' => '2025-11-03 14:30:00',
            ],
            [
                'id' => 2,
                'name' => '3 Month 599 Plan',
                'daily_limit_design' => 2,
                'daily_limit_video' => 1,
                'price' => 599,
                'duration_days' => 90,
                'status' => 'active',
                'created_at' => '2025-04-01 10:00:00',
                'updated_at' => '2025-09-09 11:20:00',
            ],
            [
                'id' => 3,
                'name' => '3 Month 599 Plan Starter',
                'daily_limit_design' => 2,
                'daily_limit_video' => 1,
                'price' => 599,
                'duration_days' => 90,
                'status' => 'active',
                'created_at' => '2025-04-01 10:00:00',
                'updated_at' => '2025-09-09 11:25:00',
            ],
            [
                'id' => 4,
                'name' => '3 Month Starter',
                'daily_limit_design' => 0,
                'daily_limit_video' => 0,
                'price' => 299,
                'duration_days' => 90,
                'status' => 'active',
                'created_at' => '2025-04-01 10:00:00',
                'updated_at' => '2025-04-01 10:00:00',
            ],
            [
                'id' => 5,
                'name' => 'Basic',
                'daily_limit_design' => 1,
                'daily_limit_video' => 1,
                'price' => 199,
                'duration_days' => 30,
                'status' => 'active',
                'created_at' => '2025-04-01 10:00:00',
                'updated_at' => '2025-11-03 16:45:00',
            ],
            [
                'id' => 6,
                'name' => 'Basic Plan Brand365',
                'daily_limit_design' => 1,
                'daily_limit_video' => 1,
                'price' => 365,
                'duration_days' => 365,
                'status' => 'active',
                'created_at' => '2025-04-01 10:00:00',
                'updated_at' => '2025-09-09 12:10:00',
            ],
        ];

        foreach ($plans as $p) {
            Plan::updateOrCreate(
                ['id' => $p['id']],
                $p
            );
        }

        $this->call(LocationSeeder::class);
        $this->call(DummyDataSeeder::class);
    }
}
