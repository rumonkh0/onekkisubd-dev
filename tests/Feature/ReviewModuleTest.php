<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Review;

class ReviewModuleTest extends TestCase
{
    protected $admin;
    protected $product;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::first();
        $this->product = Product::first();
    }

    public function test_review_pages_render_successfully()
    {
        // 1. Index page
        $response = $this->actingAs($this->admin)->get(route('reviews.index'));
        $response->assertOk();
        $response->assertViewHas('show_data');
        $response->assertViewHas('total_reviews');
        $response->assertViewHas('active_reviews');
        $response->assertViewHas('pending_reviews');
        $response->assertViewHas('avg_rating');

        // 2. Pending page
        $response = $this->actingAs($this->admin)->get(route('reviews.pending'));
        $response->assertOk();
        $response->assertViewHas('data');

        // 3. Create page
        $response = $this->actingAs($this->admin)->get(route('reviews.create'));
        $response->assertOk();
        $response->assertViewHas('products');
    }

    public function test_review_store_validation_and_lifecycle()
    {
        // Validation fails if required fields missing
        $response = $this->actingAs($this->admin)->post(route('reviews.store'), []);
        $response->assertSessionHasErrors(['product_id', 'ratting', 'review']);

        // Create active review
        $response = $this->actingAs($this->admin)->post(route('reviews.store'), [
            'product_id' => $this->product->id,
            'name' => 'John Reviewer',
            'email' => 'john@example.com',
            'ratting' => 5,
            'review' => 'Excellent quality product, fast shipping!',
            'status' => '1',
        ]);
        $response->assertRedirect(route('reviews.index'));

        $review = Review::where('name', 'John Reviewer')->first();
        $this->assertNotNull($review);
        $this->assertEquals('active', $review->status);
        $this->assertEquals(5, $review->ratting);
        $this->assertEquals($this->product->id, $review->product_id);

        // Edit page loads and status is active
        $response = $this->actingAs($this->admin)->get(route('reviews.edit', $review->id));
        $response->assertOk();
        $response->assertViewHas('edit_data');

        // Update review
        $response = $this->actingAs($this->admin)->post(route('reviews.update', $review->id), [
            'product_id' => $this->product->id,
            'name' => 'John Reviewer Updated',
            'email' => 'john_upd@example.com',
            'ratting' => 4,
            'review' => 'Very good product overall.',
            // status unchecked -> should become pending
        ]);
        $response->assertRedirect(route('reviews.index'));

        $review->refresh();
        $this->assertEquals('John Reviewer Updated', $review->name);
        $this->assertEquals(4, $review->ratting);
        $this->assertEquals('pending', $review->status);

        // Active route approves review
        $response = $this->actingAs($this->admin)->post(route('reviews.active'), [
            'hidden_id' => $review->id,
        ]);
        $response->assertRedirect();
        $review->refresh();
        $this->assertEquals('active', $review->status);

        // Inactive route moves review to pending
        $response = $this->actingAs($this->admin)->post(route('reviews.inactive'), [
            'hidden_id' => $review->id,
        ]);
        $response->assertRedirect();
        $review->refresh();
        $this->assertEquals('pending', $review->status);

        // Destroy route deletes review
        $response = $this->actingAs($this->admin)->post(route('reviews.destroy'), [
            'hidden_id' => $review->id,
        ]);
        $response->assertRedirect();
        $this->assertNull(Review::find($review->id));
    }
}
