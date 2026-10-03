<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Childcategory;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Size;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Customer;
use App\Models\Review;
use App\Models\Campaign;
use App\Models\BannerCategory;
use App\Models\Banner;
use App\Models\CreatePage;
use App\Models\GeneralSetting;
use App\Models\SocialMedia;
use App\Models\Contact;
use App\Models\ShippingCharge;
use App\Models\EcomPixel;
use App\Models\GoogleTagManager;
use App\Models\Deposit;
use App\Models\Expense;
use App\Models\Coupon;
use App\Models\Blog;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class AdminFunctionalityTest extends TestCase
{
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::first();
    }

    /**
     * Test Authentication & Dashboard
     */
    public function test_auth_and_dashboard_pages()
    {
        $this->get(route('dashboard'))->assertRedirect(route('login'));

        $this->actingAs($this->admin)
            ->get(route('dashboard'))
            ->assertStatus(200);

        $this->actingAs($this->admin)
            ->get(route('change_password'))
            ->assertStatus(200);

        $this->actingAs($this->admin)
            ->get(route('locked'))
            ->assertStatus(200);
    }

    /**
     * Test Category, Subcategory, Childcategory
     */
    public function test_category_pages()
    {
        $this->actingAs($this->admin)->get(route('categories.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('categories.create'))->assertStatus(200);

        $category = Category::first();
        if ($category) {
            $this->actingAs($this->admin)->get(route('categories.edit', $category->id))->assertStatus(200);
        }

        $this->actingAs($this->admin)->get(route('subcategories.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('subcategories.create'))->assertStatus(200);

        $sub = Subcategory::first();
        if ($sub) {
            $this->actingAs($this->admin)->get(route('subcategories.edit', $sub->id))->assertStatus(200);
        }

        $this->actingAs($this->admin)->get(route('childcategories.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('childcategories.create'))->assertStatus(200);

        $child = Childcategory::first();
        if ($child) {
            $this->actingAs($this->admin)->get(route('childcategories.edit', $child->id))->assertStatus(200);
        }
    }

    /**
     * Test Brand, Color, Size
     */
    public function test_brand_color_size_pages()
    {
        $this->actingAs($this->admin)->get(route('brands.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('brands.create'))->assertStatus(200);

        $brand = Brand::first();
        if ($brand) {
            $this->actingAs($this->admin)->get(route('brands.edit', $brand->id))->assertStatus(200);
        }

        $this->actingAs($this->admin)->get(route('colors.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('colors.create'))->assertStatus(200);

        $color = Color::first();
        if ($color) {
            $this->actingAs($this->admin)->get(route('colors.edit', $color->id))->assertStatus(200);
        }

        $this->actingAs($this->admin)->get(route('sizes.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('sizes.create'))->assertStatus(200);

        $size = Size::first();
        if ($size) {
            $this->actingAs($this->admin)->get(route('sizes.edit', $size->id))->assertStatus(200);
        }
    }

    /**
     * Test Products
     */
    public function test_product_pages()
    {
        $this->actingAs($this->admin)->get(route('products.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('products.create'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('products.price_edit'))->assertStatus(200);

        $product = Product::first();
        if ($product) {
            $this->actingAs($this->admin)->get(route('products.edit', $product->id))->assertStatus(200);
        }
    }

    /**
     * Test Orders & Reports
     */
    public function test_order_and_report_pages()
    {
        $this->actingAs($this->admin)->get(route('admin.orders', ['slug' => 'all']))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.orders', ['slug' => 'pending']))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.order.create'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.stock_report'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.order_report'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('maplist'))->assertStatus(200);

        $order = Order::first();
        if ($order) {
            $this->actingAs($this->admin)->get(route('admin.order.invoice', ['invoice_id' => $order->invoice_id]))->assertStatus(200);
            $this->actingAs($this->admin)->get(route('admin.order.edit', ['invoice_id' => $order->invoice_id]))->assertStatus(200);
            $this->actingAs($this->admin)->get(route('admin.order.process', ['invoice_id' => $order->invoice_id]))->assertStatus(200);
        }
    }

    /**
     * Test Users, Roles, Permissions
     */
    public function test_user_role_permission_pages()
    {
        $this->actingAs($this->admin)->get(route('users.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('users.create'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('users.edit', $this->admin->id))->assertStatus(200);

        $this->actingAs($this->admin)->get(route('roles.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('roles.create'))->assertStatus(200);
        $role = Role::first();
        if ($role) {
            $this->actingAs($this->admin)->get(route('roles.edit', $role->id))->assertStatus(200);
            $this->actingAs($this->admin)->get(route('roles.show', $role->id))->assertStatus(200);
        }

        $this->actingAs($this->admin)->get(route('permissions.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('permissions.create'))->assertStatus(200);
        $perm = Permission::first();
        if ($perm) {
            $this->actingAs($this->admin)->get(route('permissions.edit', $perm->id))->assertStatus(200);
        }
    }

    /**
     * Test Customers & IP Block
     */
    public function test_customer_pages()
    {
        $this->actingAs($this->admin)->get(route('customers.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('customers.ip_block'))->assertStatus(200);

        $customer = Customer::first();
        if ($customer) {
            $this->actingAs($this->admin)->get(route('customers.edit', $customer->id))->assertStatus(200);
            $this->actingAs($this->admin)->get(route('customers.profile', ['id' => $customer->id]))->assertStatus(200);
        }
    }

    /**
     * Test Accounts (Deposit & Expense)
     */
    public function test_accounts_deposit_expense_pages()
    {
        $this->actingAs($this->admin)->get(route('deposit.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('deposit.create'))->assertStatus(200);
        $deposit = Deposit::first();
        if ($deposit) {
            $this->actingAs($this->admin)->get(route('deposit.edit', $deposit->id))->assertStatus(200);
        }

        $this->actingAs($this->admin)->get(route('expense.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('expense.create'))->assertStatus(200);
        $expense = Expense::first();
        if ($expense) {
            $this->actingAs($this->admin)->get(route('expense.edit', $expense->id))->assertStatus(200);
        }

        $this->actingAs($this->admin)->get(route('deposit.filtering'))->assertStatus(200);
    }

    /**
     * Test Marketing: Campaigns, Reviews, Coupons
     */
    public function test_marketing_pages()
    {
        $this->actingAs($this->admin)->get(route('campaign.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('campaign.create'))->assertStatus(200);
        $campaign = Campaign::first();
        if ($campaign) {
            $this->actingAs($this->admin)->get(route('campaign.edit', $campaign->id))->assertStatus(200);
        }

        $this->actingAs($this->admin)->get(route('reviews.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('reviews.pending'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('reviews.create'))->assertStatus(200);
        $review = Review::first();
        if ($review) {
            $this->actingAs($this->admin)->get(route('reviews.edit', $review->id))->assertStatus(200);
        }

        $this->actingAs($this->admin)->get(route('coupon'))->assertStatus(200);
    }

    /**
     * Test Settings, Banners, Pages, API Integrations
     */
    public function test_settings_and_integrations_pages()
    {
        $this->actingAs($this->admin)->get(route('settings.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('settings.create'))->assertStatus(200);
        $setting = GeneralSetting::first();
        if ($setting) {
            $this->actingAs($this->admin)->get(route('settings.edit', $setting->id))->assertStatus(200);
        }

        $this->actingAs($this->admin)->get(route('socialmedias.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('socialmedias.create'))->assertStatus(200);
        $social = SocialMedia::first();
        if ($social) {
            $this->actingAs($this->admin)->get(route('socialmedias.edit', $social->id))->assertStatus(200);
        }

        $this->actingAs($this->admin)->get(route('contact.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('contact.create'))->assertStatus(200);
        $contact = Contact::first();
        if ($contact) {
            $this->actingAs($this->admin)->get(route('contact.edit', $contact->id))->assertStatus(200);
        }

        $this->actingAs($this->admin)->get(route('banner_category.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('banner_category.create'))->assertStatus(200);
        $bcat = BannerCategory::first();
        if ($bcat) {
            $this->actingAs($this->admin)->get(route('banner_category.edit', $bcat->id))->assertStatus(200);
        }

        $this->actingAs($this->admin)->get(route('banners.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('banners.create'))->assertStatus(200);
        $banner = Banner::first();
        if ($banner) {
            $this->actingAs($this->admin)->get(route('banners.edit', $banner->id))->assertStatus(200);
        }

        $this->actingAs($this->admin)->get(route('pages.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('pages.create'))->assertStatus(200);
        $page = CreatePage::first();
        if ($page) {
            $this->actingAs($this->admin)->get(route('pages.edit', $page->id))->assertStatus(200);
        }

        $this->actingAs($this->admin)->get(route('shippingcharges.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('shippingcharges.create'))->assertStatus(200);
        $ship = ShippingCharge::first();
        if ($ship) {
            $this->actingAs($this->admin)->get(route('shippingcharges.edit', $ship->id))->assertStatus(200);
        }

        $this->actingAs($this->admin)->get(route('pixels.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('pixels.create'))->assertStatus(200);
        $pixel = EcomPixel::first();
        if ($pixel) {
            $this->actingAs($this->admin)->get(route('pixels.edit', $pixel->id))->assertStatus(200);
        }

        $this->actingAs($this->admin)->get(route('tagmanagers.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('tagmanagers.create'))->assertStatus(200);
        $tag = GoogleTagManager::first();
        if ($tag) {
            $this->actingAs($this->admin)->get(route('tagmanagers.edit', $tag->id))->assertStatus(200);
        }

        $this->actingAs($this->admin)->get(route('orderstatus.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('orderstatus.create'))->assertStatus(200);
        $os = OrderStatus::first();
        if ($os) {
            $this->actingAs($this->admin)->get(route('orderstatus.edit', $os->id))->assertStatus(200);
        }

        $this->actingAs($this->admin)->get(route('paymentgeteway.manage'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('smsgeteway.manage'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('courierapi.manage'))->assertStatus(200);
    }

    /**
     * Test Blog Pages
     */
    public function test_blog_pages()
    {
        $this->actingAs($this->admin)->get(route('blog'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('blog_manager'))->assertStatus(200);
        $blog = Blog::first();
        if ($blog) {
            $this->actingAs($this->admin)->get(route('edit', $blog->id))->assertStatus(200);
        }
    }
}
