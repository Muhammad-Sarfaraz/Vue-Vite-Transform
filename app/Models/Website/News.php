<?php

/**
 * @OSHIT SUTRA DHAR
 */

namespace App\Models\Website;

use App\Models\Base\BaseModel;
use Illuminate\Support\Str;

class News extends BaseModel
{
    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($url) {
            $url->slug = News::createSlug($url->title);
        });
    }
    private static function createSlug($name)
    {
        $slug = Str::slug($name);
        $count = News::where(['slug' => $slug])->count();
        if ($count > 0) {
            $slug = $slug . $count;
        }
        return $slug;
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = date('Y-m-d', strtotime($value));
    }

    public function getImageAttribute($value)
    {
        if (!empty($value)) {
            return url('/') . "/public/storage/" . $value;
        }
        return null;
    }
}
