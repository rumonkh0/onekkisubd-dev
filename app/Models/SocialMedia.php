<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function booted()
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('global_socialicons');
        });
        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('global_socialicons');
        });
    }
}
