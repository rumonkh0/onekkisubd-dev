<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\LandingBanner;
use App\Models\CampaignReview;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class CampaignBannerTest extends TestCase
{
    public function test_campaign_page_renders_with_single_banner(): void
    {
        $campaign = Campaign::first();
        if (!$campaign) {
            $this->markTestSkipped('No campaign found');
        }

        // Ensure at least 1 banner
        LandingBanner::updateOrCreate(
            ['campaign_id' => $campaign->id],
            ['image' => 'public/uploads/campaign/test_banner.jpg']
        );

        $response = $this->get('/campaign/' . $campaign->slug);
        $response->assertStatus(200);
        $response->assertSee('single-banner');
    }

    public function test_campaign_page_renders_with_multiple_banners(): void
    {
        $campaign = Campaign::first();
        if (!$campaign) {
            $this->markTestSkipped('No campaign found');
        }

        LandingBanner::updateOrCreate(
            ['campaign_id' => $campaign->id, 'image' => 'public/uploads/campaign/test_banner1.jpg'],
            ['image' => 'public/uploads/campaign/test_banner1.jpg']
        );
        LandingBanner::updateOrCreate(
            ['campaign_id' => $campaign->id, 'image' => 'public/uploads/campaign/test_banner2.jpg'],
            ['image' => 'public/uploads/campaign/test_banner2.jpg']
        );

        $response = $this->get('/campaign/' . $campaign->slug);
        $response->assertStatus(200);
        $response->assertSee('camp-hero-slider');
    }

    public function test_campaign_update_appends_banners_without_deleting_old_ones(): void
    {
        $user = User::first();
        $campaign = Campaign::first();
        if (!$user || !$campaign) {
            $this->markTestSkipped('User or campaign not found');
        }

        $initialBanner = LandingBanner::create([
            'campaign_id' => $campaign->id,
            'image' => 'public/uploads/campaign/initial_test_banner.jpg',
        ]);

        $file = UploadedFile::fake()->image('new_test_banner.jpg');

        $response = $this->actingAs($user)->post(route('campaign.update'), [
            'hidden_id' => $campaign->id,
            'name' => $campaign->name,
            'status' => 1,
            'banner_img' => [$file],
        ]);

        $response->assertRedirect(route('campaign.index'));

        // Initial banner must STILL exist
        $this->assertDatabaseHas('landing_banners', [
            'id' => $initialBanner->id,
            'campaign_id' => $campaign->id,
        ]);

        // Clean up created fake banner record & file
        $newBanners = LandingBanner::where('campaign_id', $campaign->id)
            ->where('id', '!=', $initialBanner->id)
            ->get();
        foreach ($newBanners as $b) {
            if (File::exists(public_path($b->image))) {
                File::delete(public_path($b->image));
            }
            $b->delete();
        }
        $initialBanner->delete();
    }

    public function test_campaign_banner_destroy_deletes_banner(): void
    {
        $user = User::first();
        $campaign = Campaign::first();
        if (!$user || !$campaign) {
            $this->markTestSkipped('User or campaign not found');
        }

        $banner = LandingBanner::create([
            'campaign_id' => $campaign->id,
            'image' => 'public/uploads/campaign/to_delete_banner.jpg',
        ]);

        $response = $this->actingAs($user)->get(route('campaign.banner.destroy', ['id' => $banner->id]));
        $response->assertStatus(302);

        $this->assertDatabaseMissing('landing_banners', [
            'id' => $banner->id,
        ]);
    }

    public function test_campaign_dynamic_recipe_steps(): void
    {
        $campaign = Campaign::first();
        if (!$campaign) {
            $this->markTestSkipped('No campaign found');
        }

        // Test with custom steps and title
        $campaign->update([
            'step_title' => 'কাস্টম চা বানানোর ৪ ধাপ',
            'step_one' => 'কাস্টম প্রথম ধাপ বিবরণ',
            'step_two' => 'কাস্টম দ্বিতীয় ধাপ বিবরণ',
            'step_three' => 'কাস্টম তৃতীয় ধাপ বিবরণ',
            'step_four' => 'কাস্টম চতুর্থ ধাপ বিবরণ',
        ]);

        $response = $this->get('/campaign/' . $campaign->slug);
        $response->assertStatus(200);
        $response->assertSee('কাস্টম চা বানানোর ৪ ধাপ');
        $response->assertSee('কাস্টম প্রথম ধাপ বিবরণ');
        $response->assertSee('কাস্টম দ্বিতীয় ধাপ বিবরণ');
        $response->assertSee('কাস্টম তৃতীয় ধাপ বিবরণ');
        $response->assertSee('কাস্টম চতুর্থ ধাপ বিবরণ');

        // Test fallback to default when steps are null
        $campaign->update([
            'step_title' => null,
            'step_one' => null,
            'step_two' => null,
            'step_three' => null,
            'step_four' => null,
        ]);

        $response = $this->get('/campaign/' . $campaign->slug);
        $response->assertStatus(200);
        $response->assertSee('camp-recipe-section');
    }

    public function test_campaign_dynamic_comparison_section(): void
    {
        $campaign = Campaign::first();
        if (!$campaign) {
            $this->markTestSkipped('No campaign found');
        }

        // Test with custom comparison fields
        $campaign->update([
            'compare_tag' => 'আসল নকল চেনার উপায়',
            'compare_title' => 'কাস্টম রোজেলা বনাম বাজারজাত পণ্য',
            'compare_subtitle' => 'কেন আমাদের পণ্যটি শতভাগ আসল ও বিশুদ্ধ',
            'compare_good_title' => 'আমাদের প্রিমিয়াম চা',
            'compare_good_1' => '১০০% আস্ত পাতা: কোনো গুঁড়া নেই।',
            'compare_good_2' => 'কড়া লিকার: দারুণ সুবাস।',
            'compare_bad_title' => 'বাজারের সাধারণ চা',
            'compare_bad_1' => 'ভাঙা পাতা: রঙ মেশানো।',
            'compare_bad_2' => 'স্বাদহীন: কৃত্রিম ফ্লেভার।',
        ]);

        $response = $this->get('/campaign/' . $campaign->slug);
        $response->assertStatus(200);
        $response->assertSee('আসল নকল চেনার উপায়');
        $response->assertSee('কাস্টম রোজেলা বনাম বাজারজাত পণ্য');
        $response->assertSee('কেন আমাদের পণ্যটি শতভাগ আসল ও বিশুদ্ধ');
        $response->assertSee('আমাদের প্রিমিয়াম চা');
        $response->assertSee('১০০% আস্ত পাতা:');
        $response->assertSee('কোনো গুঁড়া নেই।');
        $response->assertSee('বাজারের সাধারণ চা');
        $response->assertSee('ভাঙা পাতা:');
        $response->assertSee('রঙ মেশানো।');

        // Test flexible points: fewer than 4 points (e.g. 2 points)
        $campaign->update([
            'compare_good_points' => json_encode(['পয়েন্ট এক: প্রথম ভালো দিক।', 'পয়েন্ট দুই: দ্বিতীয় ভালো দিক।'], JSON_UNESCAPED_UNICODE),
            'compare_bad_points' => json_encode(['খারাপ এক: প্রথম খারাপ দিক।', 'খারাপ দুই: দ্বিতীয় খারাপ দিক।'], JSON_UNESCAPED_UNICODE),
        ]);

        $responseFewer = $this->get('/campaign/' . $campaign->slug);
        $responseFewer->assertStatus(200);
        $responseFewer->assertSee('পয়েন্ট এক:');
        $responseFewer->assertSee('প্রথম ভালো দিক।');
        $responseFewer->assertSee('খারাপ এক:');
        $responseFewer->assertSee('প্রথম খারাপ দিক।');

        // Test flexible points: more than 4 points (e.g. 6 points)
        $sixGood = [
            'পয়েন্ট ১: এক নম্বর ভালো দিক।',
            'পয়েন্ট ২: দুই নম্বর ভালো দিক।',
            'পয়েন্ট ৩: তিন নম্বর ভালো দিক।',
            'পয়েন্ট ৪: চার নম্বর ভালো দিক।',
            'পয়েন্ট ৫: পাঁচ নম্বর ভালো দিক।',
            'পয়েন্ট ৬: ছয় নম্বর ভালো দিক।',
        ];
        $campaign->update([
            'compare_good_points' => json_encode($sixGood, JSON_UNESCAPED_UNICODE),
        ]);

        $responseMore = $this->get('/campaign/' . $campaign->slug);
        $responseMore->assertStatus(200);
        $responseMore->assertSee('পাঁচ নম্বর ভালো দিক।');
        $responseMore->assertSee('ছয় নম্বর ভালো দিক।');

        // Test fallback when comparison fields are null
        $campaign->update([
            'compare_tag' => null,
            'compare_title' => null,
            'compare_subtitle' => null,
            'compare_good_title' => null,
            'compare_good_1' => null,
            'compare_good_2' => null,
            'compare_bad_title' => null,
            'compare_bad_1' => null,
            'compare_bad_2' => null,
            'compare_good_points' => null,
            'compare_bad_points' => null,
        ]);

        $response = $this->get('/campaign/' . $campaign->slug);
        $response->assertStatus(200);
        $response->assertSee('সঠিক পণ্য চিনুন');
        $response->assertSee('camp-compare-card');
    }

    public function test_campaign_dynamic_feature_props(): void
    {
        $campaign = Campaign::first();
        if (!$campaign) {
            $this->markTestSkipped('No campaign found to test.');
        }

        // Test custom 3 feature cards
        $customFeatures = [
            [
                'icon' => 'fas fa-mug-hot',
                'title' => 'দারুণ ধোঁয়া ওঠা ফ্লেভার',
                'desc' => 'প্রতিটি কাপে অনন্য ঘ্রাণ ও অতুলনীয় স্বাদ এনে দেয়।',
            ],
            [
                'icon' => 'fas fa-truck-fast',
                'title' => '২৪ ঘণ্টায় সুপারফাস্ট ডেলিভারি',
                'desc' => 'সারা দেশে দ্রুততম ক্যাশ অন ডেলিভারি সুবিধা।',
            ],
            [
                'icon' => 'fas fa-star',
                'title' => '১০০% গ্রাহক সন্তুষ্টি',
                'desc' => 'হাজারো সন্তুষ্ট গ্রাহকের সেরা রিভিউ ও ভালোবাসা।',
            ],
        ];

        $campaign->update([
            'feature_props' => json_encode($customFeatures, JSON_UNESCAPED_UNICODE),
        ]);

        $this->assertCount(3, $campaign->fresh()->features_list);
        $this->assertEquals('fas fa-mug-hot', $campaign->fresh()->features_list[0]['icon']);

        $response = $this->get('/campaign/' . $campaign->slug);
        $response->assertStatus(200);
        $response->assertSee('দারুণ ধোঁয়া ওঠা ফ্লেভার');
        $response->assertSee('প্রতিটি কাপে অনন্য ঘ্রাণ ও অতুলনীয় স্বাদ এনে দেয়।');
        $response->assertSee('fa-mug-hot');
        $response->assertSee('২৪ ঘণ্টায় সুপারফাস্ট ডেলিভারি');
        $response->assertSee('fa-truck-fast');
        $response->assertSee('১০০% গ্রাহক সন্তুষ্টি');
        $response->assertSee('fa-star');
        $response->assertSee('props-count-3');

        // Test fallback to defaults when feature_props is null
        $campaign->update([
            'feature_props' => null,
        ]);
        $this->assertNull($campaign->fresh()->features_list);

        $responseFallback = $this->get('/campaign/' . $campaign->slug);
        $responseFallback->assertStatus(200);
        $responseFallback->assertSee('camp-props-grid');
        // Roselle default or tea default
        $responseFallback->assertSee('camp-prop-box');

        // Test admin update flow with feature cards
        $admin = User::first();
        if ($admin) {
            $postData = [
                'hidden_id' => $campaign->id,
                'name' => $campaign->name,
                'slug' => $campaign->slug,
                'status' => 1,
                'feature_icons' => ['fas fa-bolt', 'fas fa-seedling'],
                'feature_titles' => ['তাৎক্ষণিক শক্তি', '১০০% প্রাকৃতিক উপাদান'],
                'feature_descs' => ['সারা দিন চাঙ্গা ও কর্মক্ষম থাকুন।', 'রাসায়নিক ও কীটনাশক মুক্ত।'],
            ];

            $updateResp = $this->actingAs($admin)->post('/admin/campaign/update', $postData);
            $updateResp->assertRedirect();

            $updatedCampaign = $campaign->fresh();
            $this->assertNotNull($updatedCampaign->feature_props);
            $this->assertCount(2, $updatedCampaign->features_list);
            $this->assertEquals('fas fa-bolt', $updatedCampaign->features_list[0]['icon']);
            $this->assertEquals('তাৎক্ষণিক শক্তি', $updatedCampaign->features_list[0]['title']);
            $this->assertEquals('fas fa-seedling', $updatedCampaign->features_list[1]['icon']);
            $this->assertEquals('১০০% প্রাকৃতিক উপাদান', $updatedCampaign->features_list[1]['title']);
        }

        // Test YouTube video ID extraction and rendering
        $campaign->update([
            'video' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ]);
        $this->assertEquals('dQw4w9WgXcQ', $campaign->fresh()->youtube_id);
        $respYt = $this->get('/campaign/' . $campaign->slug);
        $respYt->assertOk();
        $respYt->assertSee('https://www.youtube.com/embed/dQw4w9WgXcQ');

        // Test with youtu.be short link
        $campaign->update([
            'video' => 'https://youtu.be/dQw4w9WgXcQ?si=test',
        ]);
        $this->assertEquals('dQw4w9WgXcQ', $campaign->fresh()->youtube_id);
    }
}
