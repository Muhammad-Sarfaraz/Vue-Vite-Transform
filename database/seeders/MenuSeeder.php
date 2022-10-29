<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table( 'menus' )->truncate();
        $count = DB::table( 'menus' )->count();
        if ( $count == 0 ) {
            $menus = [
                [
                    'menu_name'     => "Admin",
                    'icon'          => "<i class='fa fa-user'></i>",
                    'route_name'    => "admin.index",
                    'params'        => null,
                    'show_dasboard' => 0,
                ],
                [
                    'menu_name'     => "Contents",
                    'icon'          => "<i class='fa fa-windows'></i>",
                    'route_name'    => null,
                    'params'        => null,
                    'show_dasboard' => 0,
                    'children'      => [
                        [
                            'menu_name'     => "About Us",
                            'icon'          => "<i class='fa fa-list text-aqua'></i>",
                            'route_name'    => "content.create",
                            'params'        => "about-us",
                            'show_dasboard' => 0,
                        ],
                    ],
                ],
                [
                    'menu_name'     => "News",
                    'icon'          => "<i class='fa fa-newspaper-o'></i>",
                    'route_name'    => "news.index",
                    'params'        => null,
                    'show_dasboard' => 0,
                ],
                [
                    'menu_name'     => "Gallery / Images",
                    'icon'          => "<i class='fa fa-windows'></i>",
                    'route_name'    => null,
                    'params'        => null,
                    'show_dasboard' => 0,
                    'children'      => [
                        [
                            'menu_name'     => "Albums",
                            'icon'          => "<i class='fa fa-list text-aqua'></i>",
                            'route_name'    => "album.index",
                            'params'        => null,
                            'show_dasboard' => 0,
                        ],
                        [
                            'menu_name'     => "Photos",
                            'icon'          => "<i class='fa fa-list text-aqua'></i>",
                            'route_name'    => "photo.index",
                            'params'        => null,
                            'show_dasboard' => 0,
                        ],
                        [
                            'menu_name'     => "Videos",
                            'icon'          => "<i class='fa fa-list text-aqua'></i>",
                            'route_name'    => "video.index",
                            'params'        => null,
                            'show_dasboard' => 0,
                        ],
                        [
                            'menu_name'     => "Sliders",
                            'icon'          => "<i class='fa fa-list text-aqua'></i>",
                            'route_name'    => "slider.index",
                            'params'        => null,
                            'show_dasboard' => 0,
                        ],
                    ],
                ],
                [
                    'menu_name'     => "System Settings",
                    'icon'          => "<i class='fa fa-windows'></i>",
                    'route_name'    => null,
                    'params'        => null,
                    'show_dasboard' => 0,
                    'children'      => [
                        [
                            'menu_name'     => "Role",
                            'icon'          => "<i class='fa fa-list text-aqua'></i>",
                            'route_name'    => "role.index",
                            'params'        => null,
                            'show_dasboard' => 1,
                        ],
                        [
                            'menu_name'     => "Menu List",
                            'icon'          => "<i class='fa fa-list text-aqua'></i>",
                            'route_name'    => "menu.index",
                            'params'        => null,
                            'show_dasboard' => 0,
                        ],
                        [
                            'menu_name'     => "Website Menu List",
                            'icon'          => "<i class='fa fa-list text-aqua'></i>",
                            'route_name'    => "frontMenu.index",
                            'params'        => null,
                            'show_dasboard' => 0,
                        ],
                        [
                            'menu_name'     => "Site Settings",
                            'icon'          => "<i class='fa fa-cog text-aqua'></i>",
                            'route_name'    => "siteSetting.index",
                            'params'        => null,
                            'show_dasboard' => 1,
                        ],
                        [
                            'menu_name'     => "Activity Log",
                            'icon'          => "<i class='fa fa-history'></i>",
                            'route_name'    => "activityLog.index",
                            'params'        => null,
                            'show_dasboard' => 0,
                        ],
                        [
                            'menu_name'     => "Module Create",
                            'icon'          => "<i class='fa fa-folder text-aqua'></i>",
                            'route_name'    => "module.create",
                            'params'        => null,
                            'show_dasboard' => 0,
                        ],
                    ],
                ],
            ];

            $this->insertMenuItems( $menus, null );
        }
    }

    // Insert menus
    private function insertMenuItems( $menuItems, $parentId ) {
        if ( is_array( $menuItems ) && count( $menuItems ) > 0 ) {
            foreach ( $menuItems as $key => $item ) {
                $children = $item['children'] ?? [];
                unset( $item['children'] );

                $item['sorting']   = $key;
                $item['parent_id'] = $parentId;
                $id                = DB::table( 'menus' )->insertGetId( $item );

                if ( is_array( $children ) && count( $children ) > 0 ) {
                    $this->insertMenuItems( $children, $id );
                }
            }
        }
    }
}
