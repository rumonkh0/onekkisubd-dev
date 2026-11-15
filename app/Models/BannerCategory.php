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
}
