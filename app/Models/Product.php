<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function getRouteKeyName() {
        return 'slug';
    }
    public function image()
    {
        return $this->hasOne(Productimage::class, 'product_id')->select('id','image','product_id');
    }

    public function getImageAttribute($value)
    {
        $relation = $this->getRelationValue('image');
        if ($relation) {
            return $relation;
        }

        // Fallback 1: First slider image (PostImage)
        if (!empty($this->PostImage)) {
            $sliders = json_decode($this->PostImage, true);
            if (!empty($sliders) && is_array($sliders)) {
                $firstSlider = reset($sliders);
                if (!empty($firstSlider)) {
                    $obj = new \stdClass();
                    $obj->id = 0;
                    $obj->product_id = $this->id;
                    $obj->image = 'public/images/product/slider/' . $firstSlider;
                    return $obj;
                }
            }
        }

        // Fallback 2: Variant image
        $variant = Productcolor::where('product_id', $this->id)->whereNotNull('Image')->where('Image', '!=', '')->first();
        if ($variant && !empty($variant->Image)) {
            $obj = new \stdClass();
            $obj->id = 0;
            $obj->product_id = $this->id;
            $obj->image = $variant->Image;
            return $obj;
        }

        return null;
    }
    public function images()
    {
        return $this->hasMany(Productimage::class, 'product_id')->select('id','image','product_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id')->select('id');
    }
    public function category()
    {
        return $this->hasOne(Category::class,'id','category_id')->select('id','name','slug');
    }
    public function subcategory()
    {
        return $this->hasOne(Subcategory::class,'id','subcategory_id')->select('id','subcategoryName','slug');
    }
    public function childcategory()
    {
        return $this->hasOne(Childcategory::class,'id','childcategory_id')->select('id','childcategoryName','slug');
    }
    public function brand()
    {
        return $this->hasOne(Brand::class,'id','brand_id')->select('id','name','slug');
    }
    public function sizes()
    {
        return $this->belongsToMany('App\Models\Size','productsizes')->withTimestamps();
    }
    public function colors()
    {
        return $this->belongsToMany('App\Models\Color','productcolors')->withTimestamps();
    }
    
    public function prosizes()
    {
        return $this->hasMany('App\Models\Productsize');
    }
    public function procolors()
    {
        return $this->hasMany('App\Models\Productcolor');
    }
    
     public function prosize()
    {
        return $this->hasOne(Productsize::class, 'product_id');
    }
     public function procolor()
    {
        return $this->hasOne(Productcolor::class, 'product_id');
    }
}
