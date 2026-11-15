<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('banner_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('banner_categories', 'placement')) {
                $table->string('placement')->nullable()->after('name');
            }
        });

        // 1. Hero Left Main Slider
        $sliderCat = DB::table('banner_categories')->where('id', 1)->first();
        if ($sliderCat) {
            DB::table('banner_categories')->where('id', 1)->update([
                'name' => '1. Hero Left Main Slider (PC: 1080×640 | Tab: 960×580 | Mob: 750×480)',
                'placement' => 'hero_slider',
                'status' => 1,
            ]);
        } else {
            DB::table('banner_categories')->insert([
                'id' => 1,
                'name' => '1. Hero Left Main Slider (PC: 1080×640 | Tab: 960×580 | Mob: 750×480)',
                'placement' => 'hero_slider',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Hero Right Top Wide Banner
        $topCat = DB::table('banner_categories')->where('id', 5)->first();
        if ($topCat) {
            DB::table('banner_categories')->where('id', 5)->update([
                'name' => '2. Hero Right Top Wide Banner (PC: 770×312 | Tab: 960×366 | Mob: 750×286)',
                'placement' => 'hero_right_top',
                'status' => 1,
            ]);
        } else {
            DB::table('banner_categories')->insert([
                'id' => 5,
                'name' => '2. Hero Right Top Wide Banner (PC: 770×312 | Tab: 960×366 | Mob: 750×286)',
                'placement' => 'hero_right_top',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Hero Right Bottom-Left Banner
        $blCat = DB::table('banner_categories')->where('placement', 'hero_right_bottom_left')->first();
        if (!$blCat) {
            $blCatId = DB::table('banner_categories')->insertGetId([
                'name' => '3. Hero Right Bottom-Left Banner (PC: 377×312 | Tab: 470×368 | Mob: 365×286)',
                'placement' => 'hero_right_bottom_left',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $blCatId = $blCat->id;
        }

        // 4. Hero Right Bottom-Right Banner
        $brCat = DB::table('banner_categories')->where('placement', 'hero_right_bottom_right')->first();
        if (!$brCat) {
            $brCatId = DB::table('banner_categories')->insertGetId([
                'name' => '4. Hero Right Bottom-Right Banner (PC: 377×312 | Tab: 470×368 | Mob: 365×286)',
                'placement' => 'hero_right_bottom_right',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $brCatId = $brCat->id;
        }

        // 5. Footer Top Ads
        $footerCat = DB::table('banner_categories')->where('id', 6)->first();
        if ($footerCat) {
            DB::table('banner_categories')->where('id', 6)->update([
                'placement' => 'footer_top',
            ]);
        }

        // Migrate any 2nd/3rd banners that were saved under category_id = 5 to the new bottom-left & bottom-right categories
        $cat5Banners = DB::table('banners')->where('category_id', 5)->orderBy('id', 'ASC')->get()->values();
        if (isset($cat5Banners[1])) {
            DB::table('banners')->where('id', $cat5Banners[1]->id)->update(['category_id' => $blCatId]);
        }
        if (isset($cat5Banners[2])) {
            DB::table('banners')->where('id', $cat5Banners[2]->id)->update(['category_id' => $brCatId]);
        }
    }

    public function down()
    {
        Schema::table('banner_categories', function (Blueprint $table) {
            if (Schema::hasColumn('banner_categories', 'placement')) {
                $table->dropColumn('placement');
            }
        });
    }
};
