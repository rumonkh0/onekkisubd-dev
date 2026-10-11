<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Productsize;
use App\Models\Coupon;
use App\Models\CouponUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class PriceEditAndCouponTest extends TestCase
{
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::first();
    }

    public function test_price_edit_page_loads_and_filters()
    {
        $response = $this->actingAs($this->admin)->get(route('products.price_edit'));
        $response->assertStatus(200);
        $response->assertSee('Product Price & Stock Manage');

        // Test search filter
        $responseSearch = $this->actingAs($this->admin)->get(route('products.price_edit', ['keyword' => 'Tea']));
        $responseSearch->assertStatus(200);
    }

    public function test_price_update_updates_simple_product_and_sizes()
    {
        $product = Product::where('status', 1)->first();
        $this->assertNotNull($product);

        // Update simple product price and stock
        $newPrice = 450;
        $oldPrice = 500;
        $stock = 99;

        $response = $this->actingAs($this->admin)->post(route('products.price_update'), [
            'ids' => [$product->id],
            'old_price' => [$oldPrice],
            'new_price' => [$newPrice],
            'stock' => [$stock],
        ]);

        $response->assertRedirect();
        $product->refresh();
        $this->assertEquals($newPrice, $product->new_price);
        $this->assertEquals($oldPrice, $product->old_price);
        $this->assertEquals($stock, $product->stock);

        // If product has sizes, test variant price update
        $size = Productsize::first();
        if ($size) {
            $responseSize = $this->actingAs($this->admin)->post(route('products.price_update'), [
                'size_ids' => [$size->id],
                'size_regular_price' => [650],
                'size_sale_price' => [590],
                'size_quantity' => [45],
            ]);
            $responseSize->assertRedirect();
            $size->refresh();
            $this->assertEquals(650, $size->RegularPrice);
            $this->assertEquals(590, $size->SalePrice);
            $this->assertEquals(45, $size->quantity);
        }
    }

    public function test_coupon_store_and_apply_flow()
    {
        $couponCode = 'TESTPROMO' . rand(100, 999);

        // Store coupon via admin
        $responseStore = $this->actingAs($this->admin)->post(route('coupon.store'), [
            'coupon_name' => $couponCode,
            'coupon_type' => 1, // Solid flat ৳
            'amount' => 50,
            'quantity' => 10,
            'validity' => Carbon::now()->addDays(7)->toDateString(),
        ]);
        $responseStore->assertRedirect();

        $coupon = Coupon::where('coupon_name', $couponCode)->first();
        $this->assertNotNull($coupon);

        // Apply coupon with valid cart amount
        $responseApply = $this->post(route('coupon.apply'), [
            'coupon' => $couponCode,
            'amount' => 500,
        ]);
        $responseApply->assertStatus(200);
        $responseApply->assertJson([
            'success' => true,
            'discount' => 50,
            'amount' => 450,
        ]);

        // Verify invalid coupon returns clean error (no crash)
        $responseInvalid = $this->post(route('coupon.apply'), [
            'coupon' => 'NONEXISTENT_CODE',
            'amount' => 500,
        ]);
        $responseInvalid->assertStatus(200);
        $responseInvalid->assertJson([
            'success' => false,
            'message' => 'Invalid Coupon Code.',
        ]);

        // Clean up
        $coupon->delete();
    }
}
