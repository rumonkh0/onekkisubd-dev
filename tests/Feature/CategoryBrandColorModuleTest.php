<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Childcategory;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CategoryBrandColorModuleTest extends TestCase
{
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::first();
    }

    public function test_category_crud_and_status_toggle()
    {
        // 1. Create with status = 0 (inactive checkbox unchecked)
        $response = $this->actingAs($this->admin)->post(route('categories.store'), [
            'name' => 'Test Inactive Category',
            // status is absent when switch is unchecked
        ]);
        $response->assertRedirect(route('categories.index'));

        $category = Category::where('name', 'Test Inactive Category')->first();
        $this->assertNotNull($category);
        $this->assertEquals(0, $category->status);
        $this->assertEquals('test-inactive-category', $category->slug);

        // 2. Update to active
        $response = $this->actingAs($this->admin)->post(route('categories.update'), [
            'id' => $category->id,
            'name' => 'Test Inactive Category Updated',
            'status' => '1',
        ]);
        $response->assertRedirect(route('categories.index'));
        $category->refresh();
        $this->assertEquals(1, $category->status);
        $this->assertEquals('test-inactive-category-updated', $category->slug);

        // 3. Update to inactive (switch off)
        $response = $this->actingAs($this->admin)->post(route('categories.update'), [
            'id' => $category->id,
            'name' => 'Test Inactive Category Updated',
            // status absent
        ]);
        $response->assertRedirect(route('categories.index'));
        $category->refresh();
        $this->assertEquals(0, $category->status);

        // 4. Delete
        $response = $this->actingAs($this->admin)->post(route('categories.destroy'), [
            'hidden_id' => $category->id,
        ]);
        $this->assertNull(Category::find($category->id));
    }

    public function test_subcategory_crud_and_status_toggle()
    {
        $parent = Category::first();

        // 1. Create subcategory with switch off
        $response = $this->actingAs($this->admin)->post(route('subcategories.store'), [
            'category_id' => $parent->id,
            'subcategoryName' => 'Test Inactive Subcategory',
            // status unchecked
        ]);
        $response->assertRedirect(route('subcategories.index'));

        $sub = Subcategory::where('subcategoryName', 'Test Inactive Subcategory')->first();
        $this->assertNotNull($sub);
        $this->assertEquals(0, $sub->status);
        $this->assertEquals('test-inactive-subcategory', $sub->slug);

        // 2. Update to active
        $response = $this->actingAs($this->admin)->post(route('subcategories.update'), [
            'id' => $sub->id,
            'category_id' => $parent->id,
            'subcategoryName' => 'Test Subcategory Active',
            'status' => '1',
        ]);
        $response->assertRedirect(route('subcategories.index'));
        $sub->refresh();
        $this->assertEquals(1, $sub->status);

        // 3. Update to inactive (switch unchecked)
        $response = $this->actingAs($this->admin)->post(route('subcategories.update'), [
            'id' => $sub->id,
            'category_id' => $parent->id,
            'subcategoryName' => 'Test Subcategory Active',
            // status unchecked
        ]);
        $response->assertRedirect(route('subcategories.index'));
        $sub->refresh();
        $this->assertEquals(0, $sub->status);

        // 4. Delete
        $response = $this->actingAs($this->admin)->post(route('subcategories.destroy'), [
            'hidden_id' => $sub->id,
        ]);
        $this->assertNull(Subcategory::find($sub->id));
    }

    public function test_childcategory_crud_and_status_toggle()
    {
        $sub = Subcategory::first();

        // 1. Create childcategory with switch off
        $response = $this->actingAs($this->admin)->post(route('childcategories.store'), [
            'subcategory_id' => $sub->id,
            'childcategoryName' => 'Test Childcategory Inactive',
            // status absent
        ]);
        $response->assertRedirect(route('childcategories.index'));

        $child = Childcategory::where('childcategoryName', 'Test Childcategory Inactive')->first();
        $this->assertNotNull($child);
        $this->assertEquals(0, $child->status);

        // 2. Update with switch on
        $response = $this->actingAs($this->admin)->post(route('childcategories.update'), [
            'id' => $child->id,
            'subcategory_id' => $sub->id,
            'childcategoryName' => 'Test Childcategory Active',
            'status' => '1',
        ]);
        $response->assertRedirect(route('childcategories.index'));
        $child->refresh();
        $this->assertEquals(1, $child->status);

        // 3. Update with switch off
        $response = $this->actingAs($this->admin)->post(route('childcategories.update'), [
            'id' => $child->id,
            'subcategory_id' => $sub->id,
            'childcategoryName' => 'Test Childcategory Active',
            // status absent
        ]);
        $response->assertRedirect(route('childcategories.index'));
        $child->refresh();
        $this->assertEquals(0, $child->status);

        // 4. Delete
        $response = $this->actingAs($this->admin)->post(route('childcategories.destroy'), [
            'hidden_id' => $child->id,
        ]);
        $this->assertNull(Childcategory::find($child->id));
    }

    public function test_brand_crud_and_slug_update()
    {
        // 1. Create brand with switch off
        $response = $this->actingAs($this->admin)->post(route('brands.store'), [
            'name' => 'Brand Alpha',
            // status absent
        ]);
        $response->assertRedirect(route('brands.index'));

        $brand = Brand::where('name', 'Brand Alpha')->first();
        $this->assertNotNull($brand);
        $this->assertEquals(0, $brand->status);
        $this->assertEquals('brand-alpha', $brand->slug);

        // 2. Update brand name and slug
        $response = $this->actingAs($this->admin)->post(route('brands.update'), [
            'id' => $brand->id,
            'name' => 'Brand Beta',
            'status' => '1',
        ]);
        $response->assertRedirect(route('brands.index'));
        $brand->refresh();
        $this->assertEquals('Brand Beta', $brand->name);
        $this->assertEquals('brand-beta', $brand->slug);
        $this->assertEquals(1, $brand->status);

        // 3. Delete brand
        $response = $this->actingAs($this->admin)->post(route('brands.destroy'), [
            'hidden_id' => $brand->id,
        ]);
        $this->assertNull(Brand::find($brand->id));
    }

    public function test_color_crud_and_validation()
    {
        // 1. Validation error if name is missing
        $response = $this->actingAs($this->admin)->post(route('colors.store'), [
            'color' => '#123456',
        ]);
        $response->assertSessionHasErrors(['colorName']);

        // 2. Create color
        $response = $this->actingAs($this->admin)->post(route('colors.store'), [
            'colorName' => 'Sapphire Blue',
            'color' => '#0f52ba',
            // status absent
        ]);
        $response->assertRedirect(route('colors.index'));

        $color = Color::where('colorName', 'Sapphire Blue')->first();
        $this->assertNotNull($color);
        $this->assertEquals(0, $color->status);

        // 3. Update to active
        $response = $this->actingAs($this->admin)->post(route('colors.update'), [
            'id' => $color->id,
            'colorName' => 'Sapphire Blue Pro',
            'color' => '#0f52ba',
            'status' => '1',
        ]);
        $response->assertRedirect(route('colors.index'));
        $color->refresh();
        $this->assertEquals(1, $color->status);
        $this->assertEquals('Sapphire Blue Pro', $color->colorName);

        // 4. Update with switch off
        $response = $this->actingAs($this->admin)->post(route('colors.update'), [
            'id' => $color->id,
            'colorName' => 'Sapphire Blue Pro',
            'color' => '#0f52ba',
            // status absent
        ]);
        $response->assertRedirect(route('colors.index'));
        $color->refresh();
        $this->assertEquals(0, $color->status);

        // 5. Delete color
        $response = $this->actingAs($this->admin)->post(route('colors.destroy'), [
            'hidden_id' => $color->id,
        ]);
        $this->assertNull(Color::find($color->id));
    }
}
