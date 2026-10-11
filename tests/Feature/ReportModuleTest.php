<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\OrderStatus;
use App\Models\IpBlock;

class ReportModuleTest extends TestCase
{
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::first();
    }

    public function test_stock_report_page_renders_and_filters_correctly()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.stock_report'));
        $response->assertOk();
        $response->assertViewHasAll([
            'products',
            'categories',
            'total_stock',
            'total_price',
            'total_purchase'
        ]);

        // Test filtering by keyword
        $responseFiltered = $this->actingAs($this->admin)->get(route('admin.stock_report', [
            'keyword' => 'shirt',
        ]));
        $responseFiltered->assertOk();

        // Test filtering by category if any exists
        $category = Category::first();
        if ($category) {
            $responseCat = $this->actingAs($this->admin)->get(route('admin.stock_report', [
                'category_id' => $category->id,
            ]));
            $responseCat->assertOk();
        }
    }

    public function test_order_report_page_renders_and_handles_filters_without_crashes()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.order_report'));
        $response->assertOk();
        $response->assertViewHasAll([
            'orders',
            'users',
            'order_statuses',
            'totalPurchase',
            'total_item',
            'total_sales',
            'discounts'
        ]);

        // Test keyword filter (regression test for product_name vs name column bug)
        $responseKeyword = $this->actingAs($this->admin)->get(route('admin.order_report', [
            'keyword' => 'test',
        ]));
        $responseKeyword->assertOk();

        // Test order_status = 'all'
        $responseAllStatus = $this->actingAs($this->admin)->get(route('admin.order_report', [
            'order_status' => 'all',
        ]));
        $responseAllStatus->assertOk();

        // Test date range filter
        $responseDates = $this->actingAs($this->admin)->get(route('admin.order_report', [
            'start_date' => '2025-01-01',
            'end_date' => '2026-12-31',
        ]));
        $responseDates->assertOk();
    }

    public function test_ip_block_page_renders()
    {
        $response = $this->actingAs($this->admin)->get(route('customers.ip_block'));
        $response->assertOk();
        $response->assertViewHas('data');
    }

    public function test_ip_block_store_validation_and_creation()
    {
        $response = $this->actingAs($this->admin)
            ->from(route('customers.ip_block'))
            ->post(route('customers.ipblock.store'), []);
        $response->assertSessionHasErrors(['ip_no', 'reason']);

        $testIp = '198.51.100.' . rand(1, 250);
        $response = $this->actingAs($this->admin)
            ->from(route('customers.ip_block'))
            ->post(route('customers.ipblock.store'), [
                'ip_no' => $testIp,
                'reason' => 'Automated bot attack',
            ]);
        $response->assertRedirect(route('customers.ip_block'));
        $this->assertDatabaseHas('ip_blocks', [
            'ip_no' => $testIp,
            'reason' => 'Automated bot attack',
        ]);
    }

    public function test_ip_block_update_and_delete()
    {
        $testIp = '198.51.100.' . rand(1, 250);
        $ip = IpBlock::create([
            'ip_no' => $testIp,
            'reason' => 'Initial reason',
        ]);

        $responseUpdate = $this->actingAs($this->admin)
            ->from(route('customers.ip_block'))
            ->post(route('customers.ipblock.update'), [
                'id' => $ip->id,
                'ip_no' => $testIp,
                'reason' => 'Updated bot reason',
            ]);
        $responseUpdate->assertRedirect(route('customers.ip_block'));
        $this->assertDatabaseHas('ip_blocks', [
            'id' => $ip->id,
            'reason' => 'Updated bot reason',
        ]);

        $responseDelete = $this->actingAs($this->admin)
            ->from(route('customers.ip_block'))
            ->post(route('customers.ipblock.destroy'), [
                'id' => $ip->id,
            ]);
        $responseDelete->assertRedirect(route('customers.ip_block'));
        $this->assertDatabaseMissing('ip_blocks', [
            'id' => $ip->id,
        ]);
    }
}
