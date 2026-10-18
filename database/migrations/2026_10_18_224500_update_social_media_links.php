<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update or insert Facebook
        DB::table('social_media')->updateOrInsert(
            ['title' => 'Facebook'],
            [
                'icon' => 'fab fa-facebook-f',
                'link' => 'https://www.facebook.com/share/1Dp6Zf4dws/',
                'color' => '#3e68e5',
                'status' => 1,
                'updated_at' => now(),
            ]
        );

        // Update or insert Instagram
        DB::table('social_media')->updateOrInsert(
            ['title' => 'Instagram'],
            [
                'icon' => 'fab fa-instagram',
                'link' => 'https://www.instagram.com/onekkisubd?rpxt=MTdjMGhzamowazY0eg==',
                'color' => '#c53302',
                'status' => 1,
                'updated_at' => now(),
            ]
        );

        // Update or insert YouTube
        DB::table('social_media')->updateOrInsert(
            ['title' => 'Youtube'],
            [
                'icon' => 'fab fa-youtube',
                'link' => 'https://www.youtube.com/@onekkisuponno',
                'color' => '#ff0000',
                'status' => 1,
                'updated_at' => now(),
            ]
        );

        Cache::forget('global_socialicons');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Cache::forget('global_socialicons');
    }
};
