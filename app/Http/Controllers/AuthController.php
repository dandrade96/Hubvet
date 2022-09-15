<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends BaseController
{
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
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']); 
        }
        $user = Auth::user();
        $success['token'] = $user->createToken($user->email)->accessToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User login successfully.');
    }
    /**
     * register api
     */
    public function register(Request $request){
        $validate = Validator::make($data, [
            'name' => ['required', 'string', 'min:10','max:255'],
            'username' => ['required', 'string', 'min:6', 'unique:mysql.users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:mysql.users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        if($validate->fails()){
            return $this->sendError('Validation Error.', $validator->errors()); 
        }
        $rawData = $request->all();
        $rawData['password'] = Hash::make($request->password);
        $user = User::create($rawData);
        $success['token'] = $user->createToken($user->email)->accessToken;
        $success['name'] = $user->name;
        
        return $this->sendResponse($success, 'User register successfully.');

    }
}
