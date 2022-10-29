<?php

/**
 * @Oshit Sutra Dhar
 */

namespace App\Http\Controllers\Admin\Website\Gallery;

use App\Http\Controllers\Base\BaseController;
use App\Http\Resources\Resource;
use App\Models\Website\Gallery\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SliderController extends BaseController {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request ) {
        $query = Slider::oldest( 'sorting' );
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
        if ( $this->validateCheck( $request ) ) {
            $data = $request->all();
            $file = $request->file( 'slider' );
            if ( !empty( $file ) ) {
                $data['slider'] = $this->upload( $request->slider, 'slider' );
            }

            $res = Slider::create( $data );
            return $this->responseReturn( "create", $res );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show( Request $request, Slider $slider ) {
        if ( $request->format() == 'html' ) {
            return view( 'layouts.backend_app' );
        }
        return $slider;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit( Slider $slider ) {
        return view( 'layouts.backend_app' );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, Slider $slider ) {
        Cache::forget( 'website_cache' );
        $data = $request->all();
        $file = $request->file( 'slider' );

        if ( !empty( $file ) ) {
            $data['slider'] = $this->upload( $file, 'slider', $slider->slider );
        } else {
            $data['slider'] = $this->oldFile( $slider->slider );
        }

        $slider->update( $data );
        return $this->responseReturn( "update", $slider );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy( Slider $slider ) {
        Cache::forget( 'website_cache' );
        $old = $this->oldFile( $slider->slider );
        if ( Storage::disk( 'public' )->exists( $old ) ):
            Storage::delete( $old );
        endif;

        $res = $slider->delete();
        return $this->responseReturn( "delete", $res );
    }

    /**
     * Validate form field.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCheck( $request ) {
        return $request->validate( [
            'title'  => 'required',
            'slider' => 'required',
        ] );
    }
}
