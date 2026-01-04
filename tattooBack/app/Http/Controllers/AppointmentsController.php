<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;


class AppointmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
        $authUser = JWTAuth::parseToken()->authenticate();

        if (!$authUser){
            return response()->json([
                    'errmsg'=>'not allowed'
                ], 403);
        }

        if ($authUser->role === 'artist'){
            $appointment = Appointment::where('user_id', $authUser->id)->get();
        }else {
            //this is staff so the can see
            $appointment = Appointment::all();
        }

        return response()->
            json([
                'succmsg'=>'this is all appointments here',
                'appointments'=>$appointment
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $authUser = JWTAuth::parseToken()->authenticate();
        if(!$authUser){
            return response()->
                json([
                    'errmsg'=>'Not Allowed'
                ], 403);
        }

        $validate = $this->validate($request, [
            'artist_id'=>'required|integer',
            'service_id'=>'required|integer',
            'date'=>'required|date',
            'status'=>'required|string|in:pending,confirmed,completed,cancelled'
        ]);

        $appointment = Appointment::create($validate);

        return response()->
            json([
                'msgsucc' => 'success creation of appointment',
                'appointment'=> $appointment
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
        return response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response();
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
        return response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response();
    }
}
