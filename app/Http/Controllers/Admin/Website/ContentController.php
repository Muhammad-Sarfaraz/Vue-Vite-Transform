<?php

/**
 * @Oshit Sutra Dhar
 */

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Base\BaseController;
use App\Models\Website\Content\Content;
use App\Models\Website\Content\ContentFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentController extends BaseController {
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request ) {
        return Content::latest()->get();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( $slug = null ) {
        return view( 'layouts.backend_app' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {
        $data    = $request->all();
        $file    = $request->file( 'image' );
        $content = Content::where( 'slug', $request->slug )->first();

        if ( empty( $request->slug ) ) {
            return response()->json( ['error' => 'Slug is Missing!'], 200 );
        }
        if ( !empty( $content ) ) {
            if ( !empty( $file ) ) {
                $data['image'] = $this->upload( $file, 'content', $content->image );
            } else {
                $data['image'] = $this->oldFile( $content->image );
            }

            $content->update( $data );
        } else {
            if ( !empty( $file ) ) {
                $data['image'] = $this->upload( $file, 'content' );
            }

            $store = Content::create( $data );
        }

        $type = !empty( $content ) ? 'update' : 'create';
        $res  = $type == 'update' ? $content : $store;

        return $this->responseReturn( $type, $res );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFile( Request $request, Content $content ) {
        if ( $this->validateCheck( $request ) ) {
            $data = $request->all();
            $file = $request->file( 'file' );
            if ( !empty( $file ) ) {
                $data['file'] = $this->upload( $file, 'content-file' );
            }

            $content->contentFiles()->create( $data );
            return response()->json( ['message' => 'Create Successfully!'], 200 );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function show( Request $request, $slug ) {
        if ( $request->format() == 'html' ) {
            return view( 'layouts.backend_app' );
        }
        return Content::with( 'contentFiles' )->where( 'slug', $slug )->first() ??
            ["status" => 'active'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function destroy( ContentFile $contentFile ) {
        $old = $this->oldFile( $contentFile->file );
        if ( Storage::disk( 'public' )->exists( $old ) ) {
            Storage::delete( $old );
        }

        if ( $contentFile->delete() ) {
            return response()->json( ['message' => 'Delete Successfully!'], 200 );
        } else {
            return response()->json( ['message' => 'Delete Unsuccessfully!'], 200 );
        }
    }

    /**
     * Validate form field.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCheck( $request ) {
        return $request->validate( [
            'title' => 'required',
            'file'  => 'required',
        ] );
    }
}
