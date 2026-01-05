<?php

namespace App\Http\Controllers;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;

class AuthController extends Controller
{   
    //for registering
    public function register(Request $request){

        $this->validate($request, [ 
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'nullable|in:customer,artist' 
        ]);

       $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => app('hash')->make($request->password),
            'role' => $request->role ?? 'customer',
        ]);

        return response()->json($user, 201);
    }

    //for login 1 
    /* this works but cant decode in angular since no shape of data in payload */

    /*
    public function login(Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        $credentials = $request->only ('email', 'password');

        $token = JWTAuth::attempt($credentials);

        if ($token){
            return response()->json([
            'token' => $token,
            'goodmsg' => "Successfully logged in"
        ], 201);

            return response()->json(['error' => "Invalid Credentials"], 401);
        } 
    }
    */

    //for login 2
    public function login (Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if ($user = User::where('email', $credentials['email'])->first()) {
            if ($token = JWTAuth::claims([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ])->attempt($credentials)) {
                return response()->json([
                    'token' => $token,
                    'goodmsg' => "Successfully logged in"
                ], 201);
            } else {
                return response()->json(['error' => "Invalid Credentials"], 401);
            }
            
            return response()->json(['error' => "User not found"], 404);
        }

    }

        

    //show profile
    public function show($id){
        $user = User::findOrFail ($id);
        return response()->json($user);

    }

    // updating with jwtauth
    public function update(Request $request, $id){
        $user = User::findOrFail($id);

        //oinly allowed self-update unless artist role
        $authUser = JWTAuth::parseToken()->authenticate();
        if ($authUser->id !== $user->id && $authUser->role !== 'artist'){
            return response()->
                json(['error' => 'Not Allowed'], 403);
        }

        $user->update($request->all());
        return response()->
            json($user);
    }

    //delete
    public function destroy($id){
        $authUser = JWTAuth::parseToken()->authenticate();

        if ($authUser->role !== 'artist'){
            return response()->
                json(['error'=>'Not Allowed'], 403);
        }

        User::destroy($id);
        return response()->
            json(['msg'=>'User Deleted']);
    }

    //logout
    public function logout(Request $request){
        try {
            JWTAuth::invalidate(JWTAuth::parseToken());

            return response()->json([
                'msg' => 'Successfully logged out'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to logout, token invalid or expired'
            ], 500);
        }
        //alternative logout without try catch
        /*    
        $token = JWTAuth::getToken();
        if ($token){
            JWTAuth::invalidate(JWTAuth::parseToken());

            return response()->json([
                'msg' => 'success logout'
            ]);
        }

        
            return response()->json([
                'msg' => 'failed to logout'
            ]);
        */
    }

}
