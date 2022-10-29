<?php
/*
 *  @Developed By: Oshit Sutra Dar
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Resource;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request ) {
        $query = Admin::with( 'role' )->latest();
        $query->whereLike( $request->field_name, $request->value );
        $query->whereAny( 'status', $request->status );

        if ( $request->allData ) {
            return $query->get();
        } else {
            $datas = $query->paginate( $request->pagination );
            return new Resource( $datas );
        }
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
            $res = Admin::create( $request->all() );
            return $this->responseReturn( "create", $res );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function show( Request $request, Admin $admin ) {
        if ( $request->format() == 'html' ) {
            return view( 'layouts.backend_app' );
        }
        if ( Auth::guard( 'admin' )->user()->role_id == 1 ) {
            return Admin::with( 'role' )->find( $admin->id );
        }
        return Admin::with( 'role' )->find( Auth::guard( 'admin' )->user()->id );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function edit( Admin $admin ) {
        return view( 'layouts.backend_app' );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, Admin $admin ) {
        $ex       = explode( 'storage/', $admin->profile );
        $oldImage = $ex[1] ?? "";
        if ( !empty( $request->file( 'profile' ) ) ) {
            if ( Storage::disk( 'public' )->exists( $oldImage ) ):
                Storage::delete( $ex[1] );
            endif;
            $imgPath = Storage::putFile( 'upload/profile', $request->file( 'profile' ) );
        }
        $arr = [
            'name'    => $request->name,
            'role_id' => $request->role_id ?? $admin->role_id,
            'mobile'  => $request->mobile,
            'profile' => $imgPath ?? $oldImage,
        ];
        $admin->update( $arr );

        return $this->responseReturn( "update", $admin );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy( Admin $admin ) {
        $res = $admin->update( ['status' => 'deactive'] );

        return $this->responseReturn( "delete", $res );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function checkOldPassword( Request $request ) {
        if ( empty( $request->for_delete ) ) {
            if ( Auth::guard( 'admin' )->user()->role_id == 1 && Auth::guard( 'admin' )->user()->id != $request->id ) {
                return response()->json( true );
            }
        }
        if ( Auth::guard( 'admin' )->validate( ['password' => $request->old_password, 'id' => $request->id] ) ) {
            return response()->json( true );
        } else {
            return response()->json( false );
        }
    }
    //password change==============
    public function passwordChange( Request $request ) {
        $request->validate( [
            'new_password'     => 'required|min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required|min:6',
        ] );
        Admin::where( 'id', $request->id )->update( ['password' => $request->new_password] );
        return response()->json( ['message' => 'Password change successfully!!'], 200 );
    }

    /**
     * Validate form field.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCheck( $request ) {
        return $request->validate( [
            'name'     => 'required',
            'email'    => 'required|min:2|unique:admins',
            'password' => 'required|min:6',
            'role_id'  => 'required',
        ] );
    }
}
