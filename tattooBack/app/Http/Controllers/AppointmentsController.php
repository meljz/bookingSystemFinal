<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
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
    { try {
            if (! JWTAuth::getToken()) {
                return response()->json(['errmsg' => 'token_missing'], 401);
            }

            $authUser = JWTAuth::parseToken()->authenticate();
            
        } catch (TokenExpiredException $e) {
            return response()->json(['errmsg' => 'token_expired'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['errmsg' => 'token_invalid'], 401);
        } catch (JWTException $e) {
            return response()->json(['errmsg' => 'token_error', 'detail' => $e->getMessage()], 401);
        }
       
     

        $this->validate($request, [
            'name'=>'required|string',
            'age'=>'required|integer',
            'phone'=>'required|integer',
            //'date'=>'required|date',
            'design'=>'required|string',
        ]);

        $appointment = Appointment::create($request->only([
            'name', 'age', 'phone', 'design'
        ]));

        return response()->
            json([
                'msgsucc' => 'success creation of appointment',
                'appointment'=> $appointment
            ], 201 );
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
