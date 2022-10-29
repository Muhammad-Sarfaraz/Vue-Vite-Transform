<?php

/**
 * @OSHIT SUTRA DHAR
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Resource;
use App\Models\Test;
use Exception;
use Illuminate\Http\Request;

class TestController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request ) {
        $query = Test::latest();
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
        if ( $this->validateCheck( $request ) ) {
            try {
                $res = Test::create( $request->all() );
                return $this->responseReturn( "create", $res );
            } catch ( Exception $ex ) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show( Request $request, Test $test ) {
        if ( $request->format() == 'html' ) {
            return view( 'layouts.backend_app' );
        }
        return $test;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit( Test $test ) {
        return view( 'layouts.backend_app' );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, Test $test ) {
        if ( $this->validateCheck( $request, $test->id ) ) {
            try {
                $data = $request->all();
                $test->fill( $data )->save();

                return $this->responseReturn( "update", $test );
            } catch ( Exception $ex ) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy( Test $test ) {
        $res = $test->delete();
        return $this->responseReturn( "delete", $res );
    }

    /**
     * Validate form field.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCheck( $request, $id = null ) {
        return true;
        return $request->validate( [
            //ex: 'name' => 'required|email|nullable|date|string|min:0|max:191',
        ], [
            //ex: 'name' => "This name is required" (custom message)
        ] );
    }
}
