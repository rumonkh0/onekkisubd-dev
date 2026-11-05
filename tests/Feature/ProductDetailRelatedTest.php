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
}

