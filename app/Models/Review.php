<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function getAttachmentImagesAttribute(): array
    {
        if (!empty($this->review_images)) {
            $decoded = is_array($this->review_images) ? $this->review_images : json_decode($this->review_images, true);
            if (is_array($decoded) && count($decoded) > 0) {
                return array_values(array_filter($decoded));
            }
        }
        if (!empty($this->image)) {
            return [$this->image];
        }
        return [];
    }
}
