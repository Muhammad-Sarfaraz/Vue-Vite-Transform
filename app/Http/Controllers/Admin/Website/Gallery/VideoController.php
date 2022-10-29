<?php

/**
 * @Oshit Sutra Dhar
 */

namespace App\Http\Controllers\Admin\Website\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Resources\Resource;
use App\Models\Website\Gallery\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VideoController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request ) {
        $query = Video::with( 'album' )->oldest( 'sorting' );
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
        Cache::forget( 'website_cache' );
        $res = Video::create( $request->all() );
        return $this->responseReturn( "create", $res );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show( Request $request, Video $video ) {
        if ( $request->format() == 'html' ) {
            return view( 'layouts.backend_app' );
        }
        return $video;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit( Video $video ) {
        return view( 'layouts.backend_app' );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, Video $video ) {
        Cache::forget( 'website_cache' );
        $video->update( $request->all() );

        return $this->responseReturn( "update", $video );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy( Video $video ) {
        Cache::forget( 'website_cache' );

        $res = $video->delete();
        return $this->responseReturn( "delete", $res );
    }

    /**
     * Validate form field.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCheck( $request ) {
        return $request->validate( [
            //ex: 'name' => 'required|email|nullable|date|string|min:0|max:191',
        ] );
    }
}
