<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\UploadedFile;

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

    public function test_guest_can_submit_review_without_login()
    {
        $response = $this->post(route('customer.review'), [
            'product_id' => $this->product->id,
            'name'       => 'Guest Tester',
            'email'      => 'Dhaka',
            'ratting'    => 5,
            'review'     => 'Awesome aroma and original roselle petals!',
        ]);

        $response->assertRedirect();
        $review = Review::where('name', 'Guest Tester')->first();
        $this->assertNotNull($review);
        $this->assertEquals('active', $review->status);
        $this->assertEquals(5, $review->ratting);
        $this->assertEquals($this->product->id, $review->product_id);
        $this->assertNull($review->customer_id);
        $review->delete();
    }

    public function test_admin_can_create_backdated_review_with_preselected_product()
    {
        // Check create view accepts product_id
        $response = $this->actingAs($this->admin)->get(route('reviews.create', ['product_id' => $this->product->id]));
        $response->assertOk();
        $response->assertViewHas('selected_product_id', $this->product->id);

        $pastDate = '2026-10-15';
        $response = $this->actingAs($this->admin)->post(route('reviews.store'), [
            'product_id' => $this->product->id,
            'name'       => 'Sultana Begum',
            'email'      => 'Chittagong',
            'ratting'    => 5,
            'review'     => 'অসাধারণ টেস্ট, নিয়মিত খাব এখন থেকে।',
            'created_at' => $pastDate,
            'status'     => '1',
        ]);
        $response->assertRedirect(route('reviews.index'));

        $review = Review::where('name', 'Sultana Begum')->latest('id')->first();
        $this->assertNotNull($review);
        $this->assertEquals('2026-10-15', $review->created_at->format('Y-m-d'));
        $this->assertEquals('active', $review->status);
        $review->delete();
    }

    public function test_product_card_reviews_count_matches_active_reviews()
    {
        // Initially count active reviews
        $initialActiveCount = Review::where('product_id', $this->product->id)->where('status', 'active')->count();
        $this->assertEquals($initialActiveCount, $this->product->reviews_count);

        // Add 1 more active review
        $created = Review::create([
            'name'       => 'Count Tester',
            'email'      => 'tester@test.com',
            'ratting'    => 5,
            'review'     => 'Testing count sync',
            'product_id' => $this->product->id,
            'status'     => 'active',
        ]);

        $this->product->refresh();
        $this->assertEquals($initialActiveCount + 1, $this->product->reviews_count);
        $created->delete();
    }

    public function test_admin_and_customer_can_upload_separate_reviewer_photo_and_post_attachments()
    {
        $adminReviewerPhoto = UploadedFile::fake()->image('admin_avatar.jpg', 100, 100);
        $adminPostImg1 = UploadedFile::fake()->image('admin_post1.jpg', 300, 300);
        $adminPostImg2 = UploadedFile::fake()->image('admin_post2.jpg', 300, 300);

        $response = $this->actingAs($this->admin)->post(route('reviews.store'), [
            'product_id'     => $this->product->id,
            'name'           => 'Admin Separate Photo Tester',
            'email'          => 'Sylhet',
            'ratting'        => 5,
            'review'         => 'Separate reviewer photo and post attachments work great!',
            'reviewer_image' => $adminReviewerPhoto,
            'image'          => [$adminPostImg1, $adminPostImg2],
            'status'         => '1',
        ]);
        $response->assertRedirect(route('reviews.index'));

        $adminReview = Review::where('name', 'Admin Separate Photo Tester')->latest('id')->first();
        $this->assertNotNull($adminReview);
        $this->assertNotNull($adminReview->reviewer_image);
        $this->assertNotNull($adminReview->image);
        $this->assertNotEquals($adminReview->reviewer_image, $adminReview->image);
        $this->assertCount(2, $adminReview->attachment_images);

        // Customer end submission with separate reviewer_image and post attachment images
        $custReviewerPhoto = UploadedFile::fake()->image('cust_avatar.png', 100, 100);
        $custPostImg = UploadedFile::fake()->image('cust_post.png', 300, 300);

        $custResponse = $this->post(route('customer.review'), [
            'product_id'     => $this->product->id,
            'name'           => 'Customer Separate Photo Tester',
            'email'          => 'Dhaka',
            'ratting'        => 5,
            'review'         => 'Customer review with separate avatar and attachment!',
            'reviewer_image' => $custReviewerPhoto,
            'image'          => [$custPostImg],
        ]);
        $custResponse->assertRedirect();

        $custReview = Review::where('name', 'Customer Separate Photo Tester')->latest('id')->first();
        $this->assertNotNull($custReview);
        $this->assertNotNull($custReview->reviewer_image);
        $this->assertNotNull($custReview->image);
        $this->assertNotEquals($custReview->reviewer_image, $custReview->image);
        $this->assertCount(1, $custReview->attachment_images);

        // Check product detail page renders both distinctly
        $detailResponse = $this->get(route('product', $this->product->slug));
        $detailResponse->assertOk();
        $detailResponse->assertSee($adminReview->reviewer_image);
        foreach ($adminReview->attachment_images as $att) {
            $detailResponse->assertSee($att);
        }

        // Clean up created reviews and files via destroy
        $this->actingAs($this->admin)->post(route('reviews.destroy'), ['hidden_id' => $adminReview->id]);
        $this->actingAs($this->admin)->post(route('reviews.destroy'), ['hidden_id' => $custReview->id]);
    }
}
