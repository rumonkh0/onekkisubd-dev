<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\ShippingCharge;

class ShippingChargeModuleTest extends TestCase
{
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::first();
    }

    public function test_shipping_charge_pages_render_successfully()
    {
        // 1. Index page
        $response = $this->actingAs($this->admin)->get(route('shippingcharges.index'));
        $response->assertOk();
        $response->assertViewHas('show_data');
        $response->assertViewHas('total_charges');
        $response->assertViewHas('active_charges');
        $response->assertViewHas('inactive_charges');

        // 2. Create page
        $response = $this->actingAs($this->admin)->get(route('shippingcharges.create'));
        $response->assertOk();
    }

    public function test_shipping_charge_crud_and_status_toggles()
    {
        // Validation fails if required fields missing
        $response = $this->actingAs($this->admin)->post(route('shippingcharges.store'), []);
        $response->assertSessionHasErrors(['name', 'amount']);

        // Create new active shipping charge
        $response = $this->actingAs($this->admin)->post(route('shippingcharges.store'), [
            'name' => 'Inside Dhaka Express',
            'amount' => 70,
            'status' => '1',
        ]);
        $response->assertRedirect(route('shippingcharges.index'));

        $shipping = ShippingCharge::where('name', 'Inside Dhaka Express')->first();
        $this->assertNotNull($shipping);
        $this->assertEquals(70, $shipping->amount);
        $this->assertEquals(1, $shipping->status);

        // Edit page loads
        $response = $this->actingAs($this->admin)->get(route('shippingcharges.edit', $shipping->id));
        $response->assertOk();
        $response->assertViewHas('edit_data');

        // Update shipping charge (unchecked status -> 0)
        $response = $this->actingAs($this->admin)->post(route('shippingcharges.update'), [
            'id' => $shipping->id,
            'name' => 'Inside Dhaka Express Updated',
            'amount' => 80,
            // status unchecked
        ]);
        $response->assertRedirect(route('shippingcharges.index'));

        $shipping->refresh();
        $this->assertEquals('Inside Dhaka Express Updated', $shipping->name);
        $this->assertEquals(80, $shipping->amount);
        $this->assertEquals(0, $shipping->status);

        // Toggle active
        $response = $this->actingAs($this->admin)->post(route('shippingcharges.active'), [
            'hidden_id' => $shipping->id,
        ]);
        $response->assertRedirect();
        $shipping->refresh();
        $this->assertEquals(1, $shipping->status);

        // Toggle inactive
        $response = $this->actingAs($this->admin)->post(route('shippingcharges.inactive'), [
            'hidden_id' => $shipping->id,
        ]);
        $response->assertRedirect();
        $shipping->refresh();
        $this->assertEquals(0, $shipping->status);

        // Delete shipping charge
        $response = $this->actingAs($this->admin)->post(route('shippingcharges.destroy'), [
            'hidden_id' => $shipping->id,
        ]);
        $response->assertRedirect();
        $this->assertNull(ShippingCharge::find($shipping->id));
    }
}
