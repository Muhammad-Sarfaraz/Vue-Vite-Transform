<?php

/**
 * @Oshit Sutra Dhar
 */

namespace App\Http\Controllers\Admin\Website\Gallery;

use App\Http\Controllers\Base\BaseController;
use App\Http\Resources\Resource;
use App\Models\Website\Gallery\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends BaseController {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request ) {
        $query = Album::oldest( 'sorting' );
        $query->whereLike( $request->field_name, $request->value );

        $datas = $query->paginate( $request->pagination );
        return new Resource( $datas );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view( 'layouts.backend_app' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {
        $data = $request->all();
        $file = $request->file( 'image' );
        if ( !empty( $file ) ) {
            $data['image'] = $this->upload( $request->image, 'album' );
        }

        $res = Album::create( $data );
        return $this->responseReturn( "create", $res );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function show( Request $request, Album $album ) {
        if ( $request->format() == 'html' ) {
            return view( 'layouts.backend_app' );
        }
        return $album;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function edit( Album $album ) {
        return view( 'layouts.backend_app' );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, Album $album ) {
        $data = $request->all();
        $file = $request->file( 'image' );

        if ( !empty( $file ) ) {
            $data['image'] = $this->upload( $request->image, 'album', $album->image );
        } else {
            $data['image'] = $this->oldFile( $album->image );
        }

        $album->update( $data );
        return $this->responseReturn( "update", $album );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function destroy( Album $album ) {
        $old = $this->oldFile( $album->image );
        if ( Storage::disk( 'public' )->exists( $old ) ) {
            Storage::delete( $old );
        }

        $res = $album->delete();
        return $this->responseReturn( "delete", $res );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function album( $type ) {
        return Album::oldest( 'sorting' )->where( 'type', $type )->get( ['name', 'id'] );
    }

    /**
     * Validate form field.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCheck( $request ) {
        return $request->validate( [
            'name' => 'required',
        ] );
    }
}
