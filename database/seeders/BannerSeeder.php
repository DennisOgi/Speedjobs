<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'title' => 'BEYOND 2030',
                'description' => 'A workforce development programme - TEEN WORKFORCE PREPARATORY PROGRAMME',
                'type' => 'training',
                'is_active' => true,
                'order' => 1,
                'image' => 'banners/beyond2030.png',
                'link' => null,
            ],
            [
                'title' => 'CARE FOR THE CARETAKERS',
                'description' => 'A workforce development programme in Healthcare sector - BUILDING STATE PUBLIC HEALTH WORKFORCE',
                'type' => 'training',
                'is_active' => true,
                'order' => 2,
                'image' => 'banners/care-for-the-caretakers.png',
                'link' => null,
            ],
            [
                'title' => 'AFRICA BILATERAL TALENT EXCHANGE PROGRAMME',
                'description' => 'Africa workforce development initiative',
                'type' => 'event',
                'is_active' => true,
                'order' => 3,
                'image' => 'banners/africa-bilateral.png',
                'link' => null,
            ],
            [
                'title' => 'YOUTH ENERGY',
                'description' => "Powering Abia's green workforce - Renewable energy skills development programme",
                'type' => 'training',
                'is_active' => true,
                'order' => 4,
                'image' => 'banners/youth-energy.png',
                'link' => null,
            ],
            [
                'title' => 'University Career Center',
                'description' => 'Empowering Students for the Job Market, One Career at a Time',
                'type' => 'announcement',
                'is_active' => true,
                'order' => 5,
                'image' => 'banners/university-career-center.png',
                'link' => null,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::updateOrCreate(
                ['title' => $banner['title']],
                $banner
            );
        }
    }
}
