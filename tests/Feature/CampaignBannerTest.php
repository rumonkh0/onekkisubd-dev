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
}
