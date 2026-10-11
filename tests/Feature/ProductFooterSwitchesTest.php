<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class ProductFooterSwitchesTest extends TestCase
{
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::first();
    }

    /**
     * 1. Status switch controls site-wide visibility and 404 on direct detail view
     */
    public function test_status_switch_visibility_and_direct_url_behavior()
    {
        $product = Product::first();
        $this->assertNotNull($product);

        // Turn status ON
        $product->status = 1;
        $product->save();

        $response = $this->get(route('product', $product->slug));
        $response->assertStatus(200);
        $response->assertSee($product->name);

        // Turn status OFF
        $product->status = 0;
        $product->save();

        $response = $this->get(route('product', $product->slug));
        $response->assertStatus(404);

        // Restore status to 1
        $product->status = 1;
        $product->save();
    }

    /**
     * 2. Flash Sales (topsale) switch works on homepage and /hot-deals
     */
    public function test_flash_sales_topsale_switch_behavior()
    {
        $product = Product::first();
        $this->assertNotNull($product);

        // Set topsale to 1
        $product->status = 1;
        $product->topsale = 1;
        $product->save();

        // Hotdeals page must include this product
        $response = $this->get(route('hotdeals'));
        $response->assertStatus(200);
        $response->assertSee($product->name);

        // Homepage must render and include Flash Sales section
        $homeResponse = $this->get(route('home'));
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('FLASH SALES');
        $homeResponse->assertSee($product->name);

        // Set topsale to 0
        $product->topsale = 0;
        $product->save();

        // Hotdeals should not query products with topsale = 0
        $this->assertEquals(0, Product::where('id', $product->id)->value('topsale'));
    }

    /**
     * 3. Top Trending (feature_product) switch works on homepage
     */
    public function test_top_trending_feature_product_switch_behavior()
    {
        $product = Product::first();
        $this->assertNotNull($product);

        // Set feature_product to 1
        $product->status = 1;
        $product->feature_product = 1;
        $product->save();

        $homeResponse = $this->get(route('home'));
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('TOP');
        $homeResponse->assertSee('TRENDING');
        $homeResponse->assertSee($product->name);

        // Detail page shows promotional badge
        $detailResponse = $this->get(route('product', $product->slug));
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee('Top Trending');

        // Toggle back to 0
        $product->feature_product = 0;
        $product->save();
        $this->assertEquals(0, Product::where('id', $product->id)->value('feature_product'));
    }

    /**
     * 4. Deal Of The Day (deal_of_theday) switch works on spotlight and detail page
     */
    public function test_deal_of_the_day_switch_behavior()
    {
        $product = Product::first();
        $this->assertNotNull($product);

        // Set deal_of_theday to 1
        $product->status = 1;
        $product->deal_of_theday = 1;
        $product->save();

        $homeResponse = $this->get(route('home'));
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('Deal of the Day');
        $homeResponse->assertSee($product->name);

        // Detail page shows Deal of the Day badge
        $detailResponse = $this->get(route('product', $product->slug));
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee('Deal of the Day');

        // Toggle back to 0
        $product->deal_of_theday = 0;
        $product->save();
        $this->assertEquals(0, Product::where('id', $product->id)->value('deal_of_theday'));
    }

    /**
     * 5. Admin Product Update endpoint persists all 4 switches correctly
     */
    public function test_admin_product_update_persists_all_four_switches()
    {
        $product = Product::first();
        $this->assertNotNull($product);

        // Test with all 4 switches ON
        $payloadOn = [
            'product_id' => $product->id,
            'name' => $product->name,
            'category_id' => $product->category_id,
            'new_price' => $product->new_price,
            'old_price' => $product->old_price,
            'purchase_price' => $product->purchase_price,
            'stock' => 10,
            'status' => '1',
            'topsale' => '1',
            'feature_product' => '1',
            'deal_of_theday' => '1',
        ];

        $resOn = $this->actingAs($this->admin)->post(route('products.update'), $payloadOn);
        $resOn->assertStatus(200);
        $this->assertStringContainsString('success', $resOn->getContent());

        $product->refresh();
        $this->assertEquals(1, $product->status);
        $this->assertEquals(1, $product->topsale);
        $this->assertEquals(1, $product->feature_product);
        $this->assertEquals(1, $product->deal_of_theday);

        // Test with switches OFF (absent from request, as unchecked checkboxes)
        $payloadOff = [
            'product_id' => $product->id,
            'name' => $product->name,
            'category_id' => $product->category_id,
            'new_price' => $product->new_price,
            'old_price' => $product->old_price,
            'purchase_price' => $product->purchase_price,
            'stock' => 10,
            // status, topsale, feature_product, deal_of_theday omitted
        ];

        $resOff = $this->actingAs($this->admin)->post(route('products.update'), $payloadOff);
        $resOff->assertStatus(200);
        $this->assertStringContainsString('success', $resOff->getContent());

        $product->refresh();
        $this->assertEquals(0, $product->status);
        $this->assertEquals(0, $product->topsale);
        $this->assertEquals(0, $product->feature_product);
        $this->assertEquals(0, $product->deal_of_theday);

        // Restore back to active
        $product->status = 1;
        $product->topsale = 1;
        $product->feature_product = 1;
        $product->deal_of_theday = 1;
        $product->save();
    }
}
