<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\ShippingCharge;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Cart;

class AdminPosTest extends TestCase
{
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::first();
    }

    public function test_pos_cart_lifecycle()
    {
        $product = Product::first();
        $this->assertNotNull($product, 'At least one product should exist');

        // 1. Add to cart
        $response = $this->actingAs($this->admin)
            ->get(route('admin.order.cart_add', ['id' => $product->id]));
        $response->assertStatus(200);

        // 2. View cart content
        $response = $this->actingAs($this->admin)
            ->get(route('admin.order.cart_content'));
        $response->assertStatus(200);

        // 3. Increment cart
        $cartItem = Cart::instance('pos_shopping')->content()->first();
        $this->assertNotNull($cartItem);
        $response = $this->actingAs($this->admin)
            ->get(route('admin.order.cart_increment', ['id' => $cartItem->rowId]));
        $response->assertStatus(200);

        // 4. Decrement cart
        $response = $this->actingAs($this->admin)
            ->get(route('admin.order.cart_decrement', ['id' => $cartItem->rowId]));
        $response->assertStatus(200);

        // 5. Cart details
        $response = $this->actingAs($this->admin)
            ->get(route('admin.order.cart_details'));
        $response->assertStatus(200);

        // 6. Cart shipping
        $shipping = ShippingCharge::first();
        if ($shipping) {
            $response = $this->actingAs($this->admin)
                ->get(route('admin.order.cart_shipping', ['id' => $shipping->id]));
            $response->assertStatus(200);
        }

        // 7. Product discount
        $response = $this->actingAs($this->admin)
            ->get(route('admin.order.product_discount', ['id' => $cartItem->rowId, 'discount' => 10]));
        $response->assertStatus(200);

        // 8. Clear cart
        $response = $this->actingAs($this->admin)
            ->get(route('admin.order.cart_clear'));
        $response->assertRedirect();
    }

    public function test_pos_order_store()
    {
        DB::beginTransaction();
        try {
            $product = Product::first();
            $this->assertNotNull($product);

            // Add product to POS cart
            $this->actingAs($this->admin)
                ->get(route('admin.order.cart_add', ['id' => $product->id]));

            $shipping = ShippingCharge::first();
            $areaId = $shipping ? $shipping->id : 1;

            $postData = [
                'name' => 'POS Test Customer',
                'phone' => '01700009999',
                'address' => '123 Test Street, Dhaka',
                'area' => $areaId,
                'note' => 'POS test order note',
            ];

            $response = $this->actingAs($this->admin)
                ->post(route('admin.order.store'), $postData);

            $response->assertRedirect('admin/order/pending');

            // Verify order was created
            $order = Order::where('note', 'POS test order note')->first();
            $this->assertNotNull($order);
            $this->assertEquals(1, $order->order_status);

            // Verify shipping and payment
            $this->assertDatabaseHas('shippings', [
                'order_id' => $order->id,
                'phone' => '01700009999'
            ]);
            $this->assertDatabaseHas('payments', [
                'order_id' => $order->id,
                'payment_method' => 'Cash On Delivery'
            ]);
            $this->assertDatabaseHas('order_details', [
                'order_id' => $order->id,
                'product_id' => $product->id
            ]);
        } finally {
            DB::rollBack();
        }
    }
}
