<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public const PLACEMENTS = [
        'hero_slider' => '1. Hero Left Main Slider (Multiple Slides — PC: 1080×640, Tab: 960×580, Mob: 750×480)',
        'hero_right_top' => '2. Hero Right Top Wide Banner (PC: 770×312, Tab: 960×366, Mob: 750×286)',
        'hero_right_bottom_left' => '3. Hero Right Bottom-Left Banner (PC: 377×312, Tab: 470×368, Mob: 365×286)',
        'hero_right_bottom_right' => '4. Hero Right Bottom-Right Banner (PC: 377×312, Tab: 470×368, Mob: 365×286)',
        'footer_top' => '5. Footer Top Banner Ads',
    ];

    /**
     * Exact aspect ratios and recommended pixel dimensions for each website placement and device breakpoint.
     */
    public const PLACEMENT_SPECS = [
        'hero_slider' => [
            'label' => '1. Hero Left Main Slider',
            'image' => ['w' => 1080, 'h' => 640],
            'tablet_image' => ['w' => 960, 'h' => 580],
            'mobile_image' => ['w' => 750, 'h' => 480],
        ],
        'hero_right_top' => [
            'label' => '2. Hero Right Top Wide Banner',
            'image' => ['w' => 770, 'h' => 312],
            'tablet_image' => ['w' => 960, 'h' => 366],
            'mobile_image' => ['w' => 750, 'h' => 286],
        ],
        'hero_right_bottom_left' => [
            'label' => '3. Hero Right Bottom-Left Banner',
            'image' => ['w' => 377, 'h' => 312],
            'tablet_image' => ['w' => 470, 'h' => 368],
            'mobile_image' => ['w' => 365, 'h' => 286],
        ],
        'hero_right_bottom_right' => [
            'label' => '4. Hero Right Bottom-Right Banner',
            'image' => ['w' => 377, 'h' => 312],
            'tablet_image' => ['w' => 470, 'h' => 368],
            'mobile_image' => ['w' => 365, 'h' => 286],
        ],
        'footer_top' => [
            'label' => '5. Footer Top Banner Ads',
            'image' => ['w' => 770, 'h' => 312],
            'tablet_image' => ['w' => 770, 'h' => 312],
            'mobile_image' => ['w' => 750, 'h' => 300],
            'allow_free' => true,
        ],
    ];
}
