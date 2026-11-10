<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\GeneralSetting;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductDetailRelatedTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        if (GeneralSetting::count() === 0) {
            GeneralSetting::create([
                'name' => 'Onekkisu',
                'white_logo' => 'public/frontEnd/images/logo.png',
                'dark_logo' => 'public/frontEnd/images/logo.png',
                'favicon' => 'public/frontEnd/images/favicon.png',
            ]);
        }
    }

    public function test_details_page_loads_and_has_unique_related_products_without_duplicates(): void
    {
        $product = Product::where('status', 1)->first();
        if (!$product) {
            $category = Category::firstOrCreate(['name' => 'Test Tea'], ['slug' => 'test-tea', 'status' => 1]);
            $product = Product::create([
                'name' => 'Test Main Product',
                'slug' => 'test-main-product-' . uniqid(),
                'category_id' => $category->id,
                'old_price' => 500,
                'new_price' => 450,
                'stock' => 10,
                'status' => 1,
            ]);
        }

        $response = $this->get(route('product', $product->slug));
        $response->assertOk();
        $response->assertViewHas('products');

        $related = $response->viewData('products');

        // Verify current product is never in related list
        $this->assertFalse($related->contains('id', $product->id), 'Related products must not contain the viewed product.');

        // Verify all related products are unique
        $ids = $related->pluck('id')->all();
        $this->assertCount(count(array_unique($ids)), $ids, 'Related products must not contain duplicates.');
    }

    public function test_product_gallery_thumbnails_have_consecutive_data_ids(): void
    {
        $category = Category::firstOrCreate(['name' => 'Test Tea'], ['slug' => 'test-tea', 'status' => 1]);
        $product = Product::create([
            'name' => 'Test Gallery Product ' . uniqid(),
            'slug' => 'test-gallery-product-' . uniqid(),
            'category_id' => $category->id,
            'old_price' => 500,
            'new_price' => 450,
            'stock' => 10,
            'status' => 1,
            'PostImage' => json_encode(['gallery1.jpg', 'gallery2.jpg', 'gallery3.jpg']),
        ]);

        $pimg = new \App\Models\Productimage();
        $pimg->product_id = $product->id;
        $pimg->image = 'public/uploads/product/main.jpg';
        $pimg->save();

        $response = $this->get(route('product', $product->slug));
        $response->assertOk();

        $content = $response->getContent();

        // Must have data-id="0" (primary or first item)
        $this->assertStringContainsString('data-id="0"', $content);
        // Must have data-id="1" (MUST NOT be skipped to 2!)
        $this->assertStringContainsString('data-id="1"', $content);
        // Must have data-id="2"
        $this->assertStringContainsString('data-id="2"', $content);
        // Must have data-id="3"
        $this->assertStringContainsString('data-id="3"', $content);
    }

    public function test_product_variant_initial_and_switch_offer_rendering(): void
    {
        $category = Category::firstOrCreate(['name' => 'Variant Tea'], ['slug' => 'variant-tea', 'status' => 1]);
        $product = Product::create([
            'name' => 'Test Variant Product ' . uniqid(),
            'slug' => 'test-variant-product-' . uniqid(),
            'category_id' => $category->id,
            'old_price' => 500,
            'new_price' => 450,
            'stock' => 10,
            'status' => 1,
        ]);

        \App\Models\Productsize::create([
            'product_id' => $product->id,
            'size_id' => 1,
            'size' => '150gm',
            'RegularPrice' => 800,
            'SalePrice' => 730,
        ]);

        \App\Models\Productsize::create([
            'product_id' => $product->id,
            'size_id' => 1,
            'size' => '250gm',
            'RegularPrice' => 1325,
            'SalePrice' => 1200,
        ]);

        $response = $this->get(route('product', $product->slug));
        $response->assertOk();

        $content = $response->getContent();

        // Initial price of first variant (150gm): 730, regular: 800, save: 70, discount: 9% OFF
        $this->assertStringContainsString('id="regp">730<', $content);
        $this->assertStringContainsString('id="delp">800<', $content);
        $this->assertStringContainsString('id="save_amount">70<', $content);
        $this->assertStringContainsString('9% OFF', $content);

        // Second variant options must have proper data attributes and onclick
        $this->assertStringContainsString('data-regular="1325"', $content);
        $this->assertStringContainsString('data-sale="1200"', $content);
        $this->assertStringContainsString('setprice(1325, 1200)', $content);
    }
}

