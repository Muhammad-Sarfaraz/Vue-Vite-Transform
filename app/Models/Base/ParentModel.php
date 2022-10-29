<?php

/**
 * @OSHIT SUTRA DHAR
 */

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ParentModel extends Model {

    use LogsActivity;

    public function scopeActive( $query ) {
        return $query->where( 'status', 'active' );
    }

    public function scopePending( $query ) {
        return $query->where( 'status', 'pending' );
    }

    //--------------------------------------------------------
    // USER LOG INFO
    //--------------------------------------------------------
    protected static function boot() {
        parent::boot();
        static::creating( function ( $data ) {
            $data->created_by = Auth::user()->name;
            $data->created_ip = Request::ip();
        } );
        static::updating( function ( $data ) {
            $data->updated_by = Auth::user()->name;
            $data->updated_ip = Request::ip();
        } );
    }

    //--------------------------------------------------------
    // ACTIVITY LOG INFO
    //--------------------------------------------------------
    public function getDescriptionForEvent( string $eventName ): string {
        $name = Auth::user()->name ?? "";
        return "{$name} user {$eventName} this";
    }
    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
            ->logOnlyDirty( true )
            ->logUnguarded( true )
            ->logOnly( ['*'] )
            ->useLogName( $this->logName );
    }
}
