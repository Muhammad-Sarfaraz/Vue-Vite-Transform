<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

/** admin login */
Route::get( '/', [App\Http\Controllers\Auth\AdminLoginController::class, 'login'] )->name( 'admin.loginme' );
Route::post( '/login-admin', [App\Http\Controllers\Auth\AdminLoginController::class, 'login'] );
Route::get( '/login-check', [App\Http\Controllers\Auth\AdminLoginController::class, 'loginCheck'] )->name( 'admin.loginCheck' );

// auth verify false
Auth::routes( ['verify' => false] );

// for storage linked in public folder
Route::get( '/sym', function () {
    File::link( storage_path( 'app/public' ), public_path( 'storage' ) );
    return response()->json( "Link Create Successfully!" );
} );

// cache clear
Route::get( '/clear', function () {
    Artisan::call( 'optimize:clear' );
    return response()->json( "Cache Cleared Successfully!" );
} );
