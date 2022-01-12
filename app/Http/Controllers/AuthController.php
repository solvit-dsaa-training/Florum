<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{
    public function register(Request $res){
        $fields = $res->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'user_role'=> 'required|string|'
        ]) ;
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'user_role' => $fields['user_role']
        ]);
        $token = $user->createToken('myToken')->plainTextToken;
       
        $res = [
          'user' => $user,
          'token' => $token
        ];
        return response($res,201);
     }
     public function login(Request $request){
        
        $chk = false;

        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]) ;
        //check email
         $user = User::where('email',$fields['email'])->first();
        
         // check password
    
         if(!$user || !Hash::check($fields['password'],$user->password)){
             return response([
                 'message' => 'bad creds'
             ] , 401);
         }
    
        $token = $user->createToken('myAppToken')->plainTextToken;
       
        $response = [
          'user' => $user,
          'token' => $token,
          'status' => $chk
        ];
        return response($response,201);
     }
     public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return [
            'message' => 'logged out'
        ];
     } 
}
