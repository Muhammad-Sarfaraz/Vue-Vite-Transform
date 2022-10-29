<?php

/**
 * @Oshit Sutra Dhar
 */

namespace App\Models\Website\Gallery;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $guarded = [];

    public function getSliderAttribute($value)
    {
        if (!empty($value)) {
            return url('/') . "/public/storage/" . $value;
        }
        return null;
    }
}
