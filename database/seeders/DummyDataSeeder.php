<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Design;
use App\Models\DesignMasking;
use App\Models\ParentCategory;
use App\Models\Party;
use App\Models\Plan;
use App\Models\ReadyPhoto;
use App\Models\ReadyText;
use App\Models\RegularNotification;
use App\Models\SpecialDay;
use App\Models\StaticNotification;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\UserPremiumTemplate;
use App\Models\Video;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ==========================================
        // 1. Parent Categories
        // ==========================================
        $parentsData = [
            'Business & Services',
            'Festivals & Events',
            'Political & Leaders',
            'Daily Greetings & Suvichar',
            'Marketing & Special Offers',
        ];

        $parentModels = [];
        foreach ($parentsData as $title) {
            $parentModels[$title] = ParentCategory::firstOrCreate(
                ['title' => $title],
                ['status' => 1]
            );
        }

        // ==========================================
        // 2. Categories
        // ==========================================
        $categoriesData = [
            'Business & Services' => [
                'Restaurant & Food',
                'Real Estate & Housing',
                'Education & Coaching',
                'Healthcare & Pharmacy',
                'Salon & Beauty',
                'Tours & Travels',
            ],
            'Festivals & Events' => [
                'Diwali Festival',
                'Ganesh Chaturthi',
                'Independence Day',
                'Republic Day',
                'Eid Mubarak',
                'Navratri Mahotsav',
            ],
            'Political & Leaders' => [
                'Election Campaigning',
                'Jayanti & Punyatithi',
                'Party Greetings & Posters',
                'Leader Congratulations',
            ],
            'Daily Greetings & Suvichar' => [
                'Good Morning Quotes',
                'Good Night Messages',
                'Motivation & Success',
                'Birthday Wishes',
                'Wedding Anniversary',
            ],
            'Marketing & Special Offers' => [
                'Mega Sale Discount',
                'Grand Opening Announcement',
                'Hiring & Vacancy',
            ],
        ];

        $categoryModels = [];
        foreach ($categoriesData as $parentTitle => $cats) {
            $parentId = $parentModels[$parentTitle]->id;
            foreach ($cats as $catTitle) {
                $categoryModels[$catTitle] = Category::firstOrCreate(
                    ['title' => $catTitle, 'parent_category_id' => $parentId],
                    ['status' => 1]
                );
            }
        }

        // ==========================================
        // 3. Sub Categories
        // ==========================================
        $subCategoriesData = [
            'Restaurant & Food' => ['Cafe & Bakery', 'Fast Food & Snacks', 'Fine Dine Restaurant'],
            'Real Estate & Housing' => ['Residential Plots', 'Luxury Apartments', 'Commercial Spaces'],
            'Diwali Festival' => ['Dhanteras', 'Choti Diwali', 'Lakshmi Pujan', 'Govardhan Puja', 'Bhai Dooj'],
            'Good Morning Quotes' => ['Hindi Suvichar', 'Marathi Suvichar', 'English Quotes'],
        ];

        $subCategoryModels = [];
        foreach ($subCategoriesData as $catTitle => $subs) {
            if (isset($categoryModels[$catTitle])) {
                $cat = $categoryModels[$catTitle];
                foreach ($subs as $subTitle) {
                    $subCategoryModels[$subTitle] = SubCategory::firstOrCreate(
                        [
                            'title' => $subTitle,
                            'category_id' => $cat->id,
                            'parent_category_id' => $cat->parent_category_id,
                        ],
                        ['status' => 1]
                    );
                }
            }
        }

        // ==========================================
        // 4. Special Days
        // ==========================================
        $specialDaysData = [
            ['name' => 'Gandhi Jayanti', 'date' => '2026-10-02', 'image' => 'special-days/gandhi.png', 'status' => 1],
            ['name' => 'Diwali 2026', 'date' => '2026-11-01', 'image' => 'special-days/diwali.png', 'status' => 1],
            ['name' => 'New Year 2027', 'date' => '2027-01-01', 'image' => 'special-days/newyear.png', 'status' => 1],
            ['name' => 'Republic Day 2027', 'date' => '2027-01-26', 'image' => 'special-days/republic.png', 'status' => 1],
            ['name' => 'Shivaji Maharaj Jayanti', 'date' => '2027-02-19', 'image' => 'special-days/shivaji.png', 'status' => 1],
            ['name' => 'International Women\'s Day', 'date' => '2027-03-08', 'image' => 'special-days/womensday.png', 'status' => 1],
            ['name' => 'Maharashtra Day', 'date' => '2027-05-01', 'image' => 'special-days/maharashtra.png', 'status' => 1],
            ['name' => 'Independence Day 2027', 'date' => '2027-08-15', 'image' => 'special-days/independence.png', 'status' => 1],
        ];

        foreach ($specialDaysData as $sd) {
            SpecialDay::firstOrCreate(
                ['name' => $sd['name']],
                $sd
            );
        }

        // ==========================================
        // 5. Parties
        // ==========================================
        $partiesData = [
            [
                'name' => 'Bharatiya Janata Party (BJP)',
                'symbol' => 'parties/bjp-lotus.png',
                'state' => 'All India',
                'status' => 'active',
                'top_templates' => [['image' => 'templates/bjp_top_1.png', 'state_id' => 0]],
                'bottom_templates' => [['image' => 'templates/bjp_bottom_1.png', 'state_id' => 0]],
                'margin_left' => '10',
                'margin_right' => '10',
                'margin_top' => '10',
                'margin_bottom' => '10',
            ],
            [
                'name' => 'Indian National Congress (INC)',
                'symbol' => 'parties/inc-hand.png',
                'state' => 'All India',
                'status' => 'active',
                'top_templates' => [['image' => 'templates/inc_top_1.png', 'state_id' => 0]],
                'bottom_templates' => [['image' => 'templates/inc_bottom_1.png', 'state_id' => 0]],
                'margin_left' => '10',
                'margin_right' => '10',
                'margin_top' => '10',
                'margin_bottom' => '10',
            ],
            [
                'name' => 'Aam Aadmi Party (AAP)',
                'symbol' => 'parties/aap-broom.png',
                'state' => 'Delhi',
                'status' => 'active',
                'top_templates' => [['image' => 'templates/aap_top_1.png', 'state_id' => 0]],
                'bottom_templates' => [['image' => 'templates/aap_bottom_1.png', 'state_id' => 0]],
                'margin_left' => '10',
                'margin_right' => '10',
                'margin_top' => '10',
                'margin_bottom' => '10',
            ],
            [
                'name' => 'Shiv Sena (UBT)',
                'symbol' => 'parties/shivsena.png',
                'state' => 'Maharashtra',
                'status' => 'active',
                'top_templates' => [['image' => 'templates/ss_top_1.png', 'state_id' => 0]],
                'bottom_templates' => [['image' => 'templates/ss_bottom_1.png', 'state_id' => 0]],
                'margin_left' => '10',
                'margin_right' => '10',
                'margin_top' => '10',
                'margin_bottom' => '10',
            ],
            [
                'name' => 'Nationalist Congress Party (NCP)',
                'symbol' => 'parties/ncp-clock.png',
                'state' => 'Maharashtra',
                'status' => 'active',
                'top_templates' => [['image' => 'templates/ncp_top_1.png', 'state_id' => 0]],
                'bottom_templates' => [['image' => 'templates/ncp_bottom_1.png', 'state_id' => 0]],
                'margin_left' => '10',
                'margin_right' => '10',
                'margin_top' => '10',
                'margin_bottom' => '10',
            ],
        ];

        foreach ($partiesData as $party) {
            Party::firstOrCreate(
                ['name' => $party['name']],
                $party
            );
        }

        // ==========================================
        // 6. Coupons
        // ==========================================
        $couponsData = [
            [
                'name' => 'Welcome New User Promo',
                'code' => 'WELCOME50',
                'type' => 'percentage',
                'total' => 500,
                'discount' => 50.00,
                'max_discount' => 200.00,
                'start_date' => now()->subDays(5)->toDateString(),
                'end_date' => now()->addDays(90)->toDateString(),
                'total_uses' => 1000,
                'use_per_user' => 1,
                'status' => 1,
                'is_display' => true,
                'user_type' => ['new'],
            ],
            [
                'name' => 'Festive Mega Discount',
                'code' => 'FESTIVE100',
                'type' => 'fixed',
                'total' => 250,
                'discount' => 100.00,
                'max_discount' => 100.00,
                'start_date' => now()->toDateString(),
                'end_date' => now()->addDays(30)->toDateString(),
                'total_uses' => 500,
                'use_per_user' => 1,
                'status' => 1,
                'is_display' => true,
                'user_type' => ['all'],
            ],
            [
                'name' => 'Annual Brand365 Special',
                'code' => 'BRAND365',
                'type' => 'percentage',
                'total' => 1000,
                'discount' => 25.00,
                'max_discount' => 500.00,
                'start_date' => now()->subDays(10)->toDateString(),
                'end_date' => now()->addYear()->toDateString(),
                'total_uses' => 2000,
                'use_per_user' => 2,
                'status' => 1,
                'is_display' => true,
                'user_type' => ['all'],
            ],
        ];

        foreach ($couponsData as $cpn) {
            Coupon::firstOrCreate(
                ['code' => $cpn['code']],
                $cpn
            );
        }

        // ==========================================
        // 7. Designs
        // ==========================================
        $firstCat = Category::first();
        $firstParent = ParentCategory::first();
        $firstSub = SubCategory::first();

        $sampleDesigns = [
            [
                'design' => 'designs/restaurant_promo_1.png',
                'price' => 0.00,
                'discount' => 0.00,
                'status' => 1,
                'merging' => ['photo' => true, 'name' => true, 'mobile' => true],
                'parent_category_id' => $firstParent->id,
                'category_id' => $firstCat->id,
                'sub_category_id' => $firstSub ? $firstSub->id : null,
                'special_day' => 'Diwali 2026',
                'plan' => '1',
                'frames' => '1',
                'caption' => 'Celebrate special moments with delicious food and loved ones!',
                'state' => 'Maharashtra',
                'city' => ['Mumbai', 'Pune'],
                'party' => ['All'],
                'display_to_user' => '1',
                'watermark_text_color' => '#ffffff',
                'date' => now()->toDateString(),
                'show_in_slider' => 1,
                'only_for_today' => false,
            ],
            [
                'design' => 'designs/diwali_greetings_poster.png',
                'price' => 49.00,
                'discount' => 10.00,
                'status' => 1,
                'merging' => ['photo' => true, 'name' => true, 'logo' => true],
                'parent_category_id' => $firstParent->id,
                'category_id' => $firstCat->id,
                'special_day' => 'Diwali 2026',
                'plan' => '2',
                'frames' => '2',
                'caption' => 'शुभ दीपावली! आपके जीवन में सुख, शांति और समृद्धि आए।',
                'state' => 'Delhi',
                'city' => ['New Delhi'],
                'display_to_user' => '1',
                'watermark_text_color' => '#facc15',
                'date' => now()->toDateString(),
                'show_in_slider' => 1,
                'only_for_today' => false,
            ],
            [
                'design' => 'designs/good_morning_marathi.png',
                'price' => 0.00,
                'discount' => 0.00,
                'status' => 1,
                'merging' => ['photo' => true, 'name' => true],
                'parent_category_id' => $firstParent->id,
                'category_id' => $firstCat->id,
                'plan' => '1',
                'frames' => '3',
                'caption' => 'शुभ सकाळ! आजचा दिवस आनंदाचा आणि यशाचा जावो.',
                'state' => 'Maharashtra',
                'city' => ['Pune', 'Nashik'],
                'display_to_user' => '1',
                'date' => now()->toDateString(),
                'show_in_slider' => 0,
                'only_for_today' => false,
            ],
            [
                'design' => 'designs/political_campaign_poster.png',
                'price' => 99.00,
                'discount' => 20.00,
                'status' => 1,
                'merging' => ['photo' => true, 'name' => true, 'party' => true],
                'parent_category_id' => $firstParent->id,
                'category_id' => $firstCat->id,
                'plan' => '3',
                'frames' => '1',
                'caption' => 'विकास और विश्वास का नया संकल्प!',
                'state' => 'Uttar Pradesh',
                'city' => ['Lucknow', 'Varanasi'],
                'party' => ['Bharatiya Janata Party (BJP)'],
                'display_to_user' => '1',
                'date' => now()->toDateString(),
                'show_in_slider' => 1,
                'only_for_today' => false,
            ],
        ];

        foreach ($sampleDesigns as $d) {
            Design::firstOrCreate(
                ['design' => $d['design']],
                $d
            );
        }

        // ==========================================
        // 8. Design Maskings
        // ==========================================
        $sampleMaskings = [
            [
                'design' => 'maskings/festive_mask_overlay_1.png',
                'price' => 29.00,
                'discount' => 5.00,
                'status' => 1,
                'merging' => ['frame' => true, 'photo' => true],
                'parent_category_id' => $firstParent->id,
                'category_id' => $firstCat->id,
                'special_day' => 'Diwali 2026',
                'plan' => '1',
                'frames' => '1',
                'caption' => 'Festive gold mask border for social media',
                'language' => 'english',
                'state' => 'Maharashtra',
                'city' => ['Mumbai'],
                'party' => ['All'],
                'display_to_user' => '1',
                'watermark_text_color' => '#ffffff',
                'date' => now()->toDateString(),
                'show_in_slider' => 1,
                'only_for_today' => false,
            ],
            [
                'design' => 'maskings/political_badge_mask_2.png',
                'price' => 0.00,
                'discount' => 0.00,
                'status' => 1,
                'merging' => ['party_badge' => true, 'profile' => true],
                'parent_category_id' => $firstParent->id,
                'category_id' => $firstCat->id,
                'plan' => '2',
                'frames' => '2',
                'caption' => 'Official Leader Protocol Frame Masking',
                'language' => 'hindi',
                'state' => 'Delhi',
                'city' => ['New Delhi'],
                'party' => ['Bharatiya Janata Party (BJP)', 'Indian National Congress (INC)'],
                'display_to_user' => '1',
                'date' => now()->toDateString(),
                'show_in_slider' => 0,
                'only_for_today' => false,
            ],
        ];

        foreach ($sampleMaskings as $dm) {
            DesignMasking::firstOrCreate(
                ['design' => $dm['design']],
                $dm
            );
        }

        // ==========================================
        // 9. Videos
        // ==========================================
        $sampleVideos = [
            [
                'video' => 'videos/diwali_animated_reel.mp4',
                'thumbnail' => 'videos/diwali_reel_thumb.png',
                'price' => 149.00,
                'discount' => 30.00,
                'status' => 1,
                'merging' => ['lower_third' => true, 'photo' => true, 'logo' => true],
                'parent_category_id' => $firstParent->id,
                'category_id' => $firstCat->id,
                'special_day' => 'Diwali 2026',
                'language' => 'hindi',
                'plan' => '2',
                'frames' => '1',
                'caption' => '3D Animated Diya & Lights Diwali Video Reel (9:16)',
                'state' => 'All',
                'display_to_user' => '1',
                'date' => now()->toDateString(),
                'show_in_slider' => 1,
                'only_for_today' => false,
            ],
            [
                'video' => 'videos/good_morning_motion.mp4',
                'thumbnail' => 'videos/good_morning_thumb.png',
                'price' => 0.00,
                'discount' => 0.00,
                'status' => 1,
                'merging' => ['photo' => true, 'quote' => true],
                'parent_category_id' => $firstParent->id,
                'category_id' => $firstCat->id,
                'language' => 'marathi',
                'plan' => '1',
                'frames' => '2',
                'caption' => 'Sunrise Nature Motivation Motion Reel',
                'state' => 'Maharashtra',
                'display_to_user' => '1',
                'date' => now()->toDateString(),
                'show_in_slider' => 0,
                'only_for_today' => false,
            ],
            [
                'video' => 'videos/republic_day_patriotic.mp4',
                'thumbnail' => 'videos/republic_thumb.png',
                'price' => 99.00,
                'discount' => 15.00,
                'status' => 1,
                'merging' => ['tricolor' => true, 'profile' => true],
                'parent_category_id' => $firstParent->id,
                'category_id' => $firstCat->id,
                'special_day' => 'Republic Day 2027',
                'language' => 'english',
                'plan' => '3',
                'frames' => '1',
                'caption' => 'Tricolor Independence and Republic Anthem Reel',
                'state' => 'All India',
                'display_to_user' => '1',
                'date' => now()->toDateString(),
                'show_in_slider' => 1,
                'only_for_today' => false,
            ],
        ];

        foreach ($sampleVideos as $v) {
            Video::firstOrCreate(
                ['video' => $v['video']],
                $v
            );
        }

        // ==========================================
        // 10. Ready Photos & Ready Texts
        // ==========================================
        $sampleReadyPhotos = [
            [
                'image' => 'ready-photos/pm_modi_namaste.png',
                'party' => ['Bharatiya Janata Party (BJP)'],
                'sort_order' => 1,
                'status' => 1,
                'parent_category_id' => $firstParent->id,
                'category_id' => $firstCat->id,
            ],
            [
                'image' => 'ready-photos/rahul_gandhi_rally.png',
                'party' => ['Indian National Congress (INC)'],
                'sort_order' => 2,
                'status' => 1,
                'parent_category_id' => $firstParent->id,
                'category_id' => $firstCat->id,
            ],
            [
                'image' => 'ready-photos/arvind_kejriwal_speech.png',
                'party' => ['Aam Aadmi Party (AAP)'],
                'sort_order' => 3,
                'status' => 1,
                'parent_category_id' => $firstParent->id,
                'category_id' => $firstCat->id,
            ],
            [
                'image' => 'ready-photos/sharad_pawar_meeting.png',
                'party' => ['Nationalist Congress Party (NCP)'],
                'sort_order' => 4,
                'status' => 1,
                'parent_category_id' => $firstParent->id,
                'category_id' => $firstCat->id,
            ],
        ];

        foreach ($sampleReadyPhotos as $rp) {
            ReadyPhoto::firstOrCreate(
                ['image' => $rp['image']],
                $rp
            );
        }

        $sampleReadyTexts = [
            [
                'image' => 'ready-texts/diwali_shubhkaamna_hindi.png',
                'party' => ['All'],
                'sort_order' => 1,
                'status' => 1,
                'parent_category_id' => $firstParent->id,
                'category_id' => $firstCat->id,
            ],
            [
                'image' => 'ready-texts/nava_varshachya_hardik_shubhechha.png',
                'party' => ['All'],
                'sort_order' => 2,
                'status' => 1,
                'parent_category_id' => $firstParent->id,
                'category_id' => $firstCat->id,
            ],
            [
                'image' => 'ready-texts/vijayadashami_shubhechha.png',
                'party' => ['Bharatiya Janata Party (BJP)', 'Shiv Sena (UBT)'],
                'sort_order' => 3,
                'status' => 1,
                'parent_category_id' => $firstParent->id,
                'category_id' => $firstCat->id,
            ],
        ];

        foreach ($sampleReadyTexts as $rt) {
            ReadyText::firstOrCreate(
                ['image' => $rt['image']],
                $rt
            );
        }

        // ==========================================
        // 11. Regular & Static Notifications
        // ==========================================
        $sampleRegularNotifs = [
            [
                'title' => '🎉 Diwali New Posters Live Now!',
                'message' => 'Explore 50+ new premium festival posters and animated video reels for your branding.',
                'image' => 'notifications/diwali_banner.png',
                'video' => null,
                'notification_type' => 'promotional',
                'sub_type' => 'festival',
                'firebase_topic' => 'all_users',
            ],
            [
                'title' => '⚡ 50% Off On Annual Pro Plan',
                'message' => 'Use coupon BRAND365 at checkout to unlock unlimited daily video and poster downloads.',
                'image' => 'notifications/discount_offer.png',
                'video' => null,
                'notification_type' => 'offer',
                'sub_type' => 'plan_discount',
                'firebase_topic' => 'free_users',
            ],
            [
                'title' => 'Good Morning Motivation',
                'message' => 'Start your day with positive energy. Check today\'s curated thoughts and suvichar.',
                'image' => 'notifications/morning_quote.png',
                'video' => null,
                'notification_type' => 'daily_greet',
                'sub_type' => 'morning',
                'firebase_topic' => 'active_members',
            ],
        ];

        foreach ($sampleRegularNotifs as $rn) {
            RegularNotification::firstOrCreate(
                ['title' => $rn['title']],
                $rn
            );
        }

        $sampleStaticNotifs = [
            [
                'image' => 'notifications/static_popup_diwali.png',
                'video' => null,
                'notification_type' => 'banner_popup',
                'sub_type' => 'special_day',
                'user_plan' => ['1', '2', '3'],
                'status' => 1,
                'start_time' => now()->subDay(),
                'end_time' => now()->addDays(30),
                'language' => 'hindi',
                'state' => 'All',
                'city' => ['All'],
                'party' => ['All'],
            ],
            [
                'image' => 'notifications/static_banner_election.png',
                'video' => null,
                'notification_type' => 'home_slider',
                'sub_type' => 'political',
                'user_plan' => ['2', '3'],
                'status' => 1,
                'start_time' => now()->subDays(2),
                'end_time' => now()->addDays(60),
                'language' => 'marathi',
                'state' => 'Maharashtra',
                'city' => ['Mumbai', 'Pune'],
                'party' => ['All'],
            ],
        ];

        foreach ($sampleStaticNotifs as $sn) {
            StaticNotification::firstOrCreate(
                ['image' => $sn['image']],
                $sn
            );
        }
    }
}
