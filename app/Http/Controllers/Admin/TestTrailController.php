<?php

/**
 * @OSHIT SUTRA DHAR
 */

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\Resource;
use App\Models\TestTrail;
use Exception;
use Illuminate\Http\Request;

class TestTrailController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request ) {
        $query = TestTrail::latest();
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
                $res = TestTrail::create( $request->all() );
                return $this->responseReturn( "create", $res );
            } catch ( Exception $ex ) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TestTrail  $testTrail
     * @return \Illuminate\Http\Response
     */
    public function show( Request $request, TestTrail $testTrail ) {
        if ( $request->format() == 'html' ) {
            return view( 'layouts.backend_app' );
        }
        return $testTrail;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TestTrail  $testTrail
     * @return \Illuminate\Http\Response
     */
    public function edit( TestTrail $testTrail ) {
        return view( 'layouts.backend_app' );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TestTrail  $testTrail
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, TestTrail $testTrail ) {
        if ( $this->validateCheck( $request, $testTrail->id ) ) {
            try {
                $data = $request->all();
                $testTrail->fill( $data )->save();

                return $this->responseReturn( "update", $testTrail );
            } catch ( Exception $ex ) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TestTrail  $testTrail
     * @return \Illuminate\Http\Response
     */
    public function destroy( TestTrail $testTrail ) {
        $res = $testTrail->delete();
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
