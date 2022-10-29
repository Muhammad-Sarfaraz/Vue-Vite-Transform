<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class LibController extends Controller {
    private $variable = [];

    private function index() {
        return [
            'variable' => $this->variable,
        ];
    }

    /**
     * SYSTEMS DATA RETURN
     */
    public function systems() {
        return [
            "global"      => $this->index(),
            "permissions" => App::make( 'premitedMenuArr' ),
            "site"        => App::make( 'siteSettingObj' ),
            "menus"       => App::make( 'sideMenus' ),
        ];
    }
}
