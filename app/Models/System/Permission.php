<?php

/**
 * @Oshit Sutra Dhar
 */

namespace App\Models\System;

use App\Models\Base\BaseModel;

class Permission extends BaseModel {
    protected $guarded = ['id'];
    public $timestamps = false;

    protected $logName = 'Permission';

    public function parent() {
        return $this->belongsTo( Permission::class, 'parent_id' );
    }
    //EACH CATEGORY MIGHT HAVE MULTIPLE CHILDREN
    public function children() {
        return $this->hasMany( Permission::class, 'parent_id' );
    }
}
