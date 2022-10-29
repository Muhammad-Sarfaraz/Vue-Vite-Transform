<?php

/**
 * @Oshit Sutra Dhar
 */

namespace App\Models\Website\Content;

use App\Models\Base\BaseModel;

class Content extends BaseModel
{

    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function contentFiles()
    {
        return $this->hasMany(ContentFile::class)->oldest('sorting');
    }

    public function getImageAttribute($value)
    {
        if (!empty($value)) {
            return url('/') . "/public/storage/" . $value;
        }
        return null;
    }
}
