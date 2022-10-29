<?php

/**
 * @Oshit Sutra Dhar
 */

namespace App\Models\System;

use App\Models\Base\BaseModel;

class SiteSetting extends BaseModel {
    protected $guarded = ['id'];

    protected $logName = 'Site Settings';

    public function getLogoAttribute( $value ) {
        if ( !empty( $value ) ) {
            return url( '/' ) . "/public/storage/" . $value;
        }
        return null;
    }
    public function getLogoSmallAttribute( $value ) {
        if ( !empty( $value ) ) {
            return url( '/' ) . "/public/storage/" . $value;
        }
        return null;
    }
    public function getFaviconAttribute( $value ) {
        if ( !empty( $value ) ) {
            return url( '/' ) . "/public/storage/" . $value;
        }
        return null;
    }
}
