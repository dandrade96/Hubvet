<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public CONST successStatus = 200;

    /**
     * validate register api
     */
    protected function validator(array $data){
        return Validator::make($data, [
            'name' => ['required', 'string', 'min:10','max:255'],
            'username' => ['required', 'string', 'min:6', 'unique:mysql.users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:mysql.users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }
    /**
     * login api
     */

    public function login(Request $request){
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
        
        if(!Auth::attempt($credentials)){
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);   
        }
        $user = Auth::user();
        $success['token'] = $user->createToken($user->email)->accessToken;
        return response()->json([
            'success' => $success
        ], AuthController::successStatus);
    }
    /**
     * register api
     */
    public function register(Request $request){
        if($this->validator($request->all())->fails()){
            $error = $this->validator($request->all())->messages();
            return response()->json([
                $error
            ], 401); 
        }
        $rawData = $request->all();
        $rawData['password'] = Hash::make($request->password);
        $user = User::create($rawData);
        $success['token'] = $user->createToken($user->email)->accessToken;
        $success['name'] = $user->name;
        
        return response()->json([
            'success' =>  $success
        ], AuthController::successStatus);

    }
}
