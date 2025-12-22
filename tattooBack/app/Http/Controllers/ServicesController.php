<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Tymon\JWTAuth\Facades\JWTAuth;




class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authUser = JWTAuth::parseToken()->authenticate();
        if(!$authUser){
            return response()->
                json([
                    "errmsg"=>"Not Allowed",
                ], 403);
        }

        return response()->json(Service::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $authUser = JWTAuth::parseToken()->authenticate();

        if ($authUser->role !== 'artist'){
            return response()->
                json([
                    'msgerr' => 'Not Allowed'
                ], 403);
        } 

        $validate = $this->validate($request, [
            'name'=>'required|string',
            'description'=>'required|string',
            'duration' => 'required|numeric',
            'price'=>'required|numeric'
        ]);

        $service = Service::create($validate);

        return response()->
            json([
                'msgsucc' => 'success input',
                'service' => $service
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $authUser = JWTAuth::parseToken()->authenticate();

        if ($authUser->role !== 'artist'){
            return response()->
                json([
                    'msgerr' => 'Not Allowed'
                ], 403);
        }

        $service = Service::findOrFail($id);

        return response()->
            json([
                "succmsg" => "specific service shows success",
                'service' => $service
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $authUser = JWTAuth::parseToken()->authenticate();

        if ($authUser->role !== 'artist'){
            return response()->
                json(['error'=>'Not Allowed'], 403);
        }

        Service::destroy($id);
        return response()->
            json(['msg'=>'User Deleted']);
    
    }
}
