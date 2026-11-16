<?php

namespace Tests\Feature;

use App\Models\Banner;
use App\Models\BannerCategory;
use App\Models\GeneralSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class BannerPlacementCropperTest extends TestCase
{
    use DatabaseTransactions;

    protected ?User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::first();
    }

    public function test_general_setting_edit_renders_cropper_assets_and_slot_inputs(): void
    {
        if (!$this->admin) {
            $this->markTestSkipped('No admin user found');
        }
        $gs = GeneralSetting::first();
        if (!$gs) {
            $this->markTestSkipped('No general setting found');
        }

        $response = $this->actingAs($this->admin)->get(route('settings.edit', $gs->id));

        $response->assertStatus(200);
        $response->assertSee('cropper.min.css');
        $response->assertSee('cropper.min.js');
        $response->assertSee('id="bannerCropperModal"', false);
        $response->assertSee('data-placement="hero_slider"', false);
        $response->assertSee('data-placement="hero_right_top"', false);
        $response->assertSee('data-placement="hero_right_bottom_left"', false);
        $response->assertSee('data-placement="hero_right_bottom_right"', false);
        $response->assertSee('"hero_slider":', false);
        $response->assertSee('"w":1080,"h":640', false);
    }

    public function test_banner_create_and_edit_render_cropper_with_placement_source(): void
    {
        if (!$this->admin) {
            $this->markTestSkipped('No admin user found');
        }

        $createRes = $this->actingAs($this->admin)->get(route('banners.create'));
        $createRes->assertStatus(200);
        $createRes->assertSee('cropper.min.css');
        $createRes->assertSee('cropper.min.js');
        $createRes->assertSee('id="bannerCropperModal"', false);
        $createRes->assertSee('data-placement-source="#category_id"', false);
        $createRes->assertSee('data-placement="hero_right_top"', false);

        $banner = Banner::first();
        if ($banner) {
            $editRes = $this->actingAs($this->admin)->get(route('banners.edit', $banner->id));
            $editRes->assertStatus(200);
            $editRes->assertSee('id="bannerCropperModal"', false);
            $editRes->assertSee('data-placement-source="#category_id"', false);
            $editRes->assertSee('data-existing-src=', false);
        }
    }

    public function test_banner_category_store_requires_and_persists_placement(): void
    {
        if (!$this->admin) {
            $this->markTestSkipped('No admin user found');
        }

        $missingPlacement = $this->actingAs($this->admin)->post(route('banner_category.store'), [
            'name' => 'No Placement Test',
            'status' => 1,
        ]);
        $missingPlacement->assertSessionHasErrors('placement');

        $valid = $this->actingAs($this->admin)->post(route('banner_category.store'), [
            'name' => 'Test Promo Bottom Left Category',
            'placement' => 'hero_right_bottom_left',
            'status' => 1,
        ]);
        $valid->assertRedirect(route('banner_category.index'));

        $this->assertDatabaseHas('banner_categories', [
            'name' => 'Test Promo Bottom Left Category',
            'placement' => 'hero_right_bottom_left',
        ]);
    }

    public function test_banner_store_accepts_cropped_responsive_uploads(): void
    {
        if (!$this->admin) {
            $this->markTestSkipped('No admin user found');
        }

        $category = BannerCategory::where('placement', 'hero_right_top')->first();
        if (!$category) {
            $category = BannerCategory::create([
                'name' => 'Right Top Test',
                'placement' => 'hero_right_top',
                'status' => 1,
            ]);
        }

        $pcFile = UploadedFile::fake()->image('cropped-pc.jpg', 770, 312);
        $tabFile = UploadedFile::fake()->image('cropped-tab.jpg', 960, 366);
        $mobFile = UploadedFile::fake()->image('cropped-mob.jpg', 750, 286);

        $createdBanner = null;
        try {
            $res = $this->actingAs($this->admin)->post(route('banners.store'), [
                'link' => 'https://onekkisubd.com/shop',
                'category_id' => $category->id,
                'status' => 1,
                'image' => $pcFile,
                'tablet_image' => $tabFile,
                'mobile_image' => $mobFile,
            ]);

            $res->assertRedirect(route('banners.index'));

            $createdBanner = Banner::where('category_id', $category->id)
                ->where('link', 'https://onekkisubd.com/shop')
                ->latest('id')
                ->first();

            $this->assertNotNull($createdBanner);
            $this->assertNotEmpty($createdBanner->image);
            $this->assertNotEmpty($createdBanner->tablet_image);
            $this->assertNotEmpty($createdBanner->mobile_image);
        } finally {
            if ($createdBanner) {
                foreach (['image', 'tablet_image', 'mobile_image'] as $col) {
                    if ($createdBanner->$col && File::exists(base_path($createdBanner->$col))) {
                        File::delete(base_path($createdBanner->$col));
                    }
                }
            }
        }
    }
}
