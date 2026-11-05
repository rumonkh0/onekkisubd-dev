<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function product(){
        return $this->hasOne(Product::class, 'id','product_id')->select('id','name','slug','old_price','new_price');
    }
    public function images(){
        return $this->hasMany(CampaignReview::class, 'campaign_id')->select('id','image','campaign_id');
    }
    public function banners(){
        return $this->hasMany(LandingBanner::class, 'campaign_id')->select('id','image','campaign_id');
    }

    public function getGoodPointsAttribute()
    {
        if (!empty($this->compare_good_points)) {
            $decoded = is_array($this->compare_good_points) ? $this->compare_good_points : json_decode($this->compare_good_points, true);
            if (is_array($decoded)) {
                $filtered = array_values(array_filter($decoded, fn($v) => !empty(trim($v ?? ''))));
                if (count($filtered) > 0) {
                    return $filtered;
                }
            }
        }

        $legacy = array_values(array_filter([
            $this->compare_good_1,
            $this->compare_good_2,
            $this->compare_good_3,
            $this->compare_good_4,
        ], fn($v) => !empty(trim($v ?? ''))));

        if (count($legacy) > 0) {
            return $legacy;
        }

        return null;
    }

    public function getBadPointsAttribute()
    {
        if (!empty($this->compare_bad_points)) {
            $decoded = is_array($this->compare_bad_points) ? $this->compare_bad_points : json_decode($this->compare_bad_points, true);
            if (is_array($decoded)) {
                $filtered = array_values(array_filter($decoded, fn($v) => !empty(trim($v ?? ''))));
                if (count($filtered) > 0) {
                    return $filtered;
                }
            }
        }

        $legacy = array_values(array_filter([
            $this->compare_bad_1,
            $this->compare_bad_2,
            $this->compare_bad_3,
            $this->compare_bad_4,
        ], fn($v) => !empty(trim($v ?? ''))));

        if (count($legacy) > 0) {
            return $legacy;
        }

        return null;
    }
}
