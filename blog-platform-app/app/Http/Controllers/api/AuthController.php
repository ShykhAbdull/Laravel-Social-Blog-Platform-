<?php


namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5'
        ]);

        $user = User::where('email', $validatedData['email'])->first();

        // Check if the user is already authenticated and has an active token
        $validate = Auth::attempt($validatedData);  // true in case credentials matches  
        if ($user && $validate) {
        
        // Always create a new token to ensure Postman gets a token for environment variable
        $new_token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $new_token,
        ], 200);
    }
        

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {

        try{
            $request->user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out'], 200);

        } catch(\Exception $e){
            return response()->json(['Token Error' => 'Your Token may have expired or Invalid', 
            'Error Message' => $e->getMessage() 
            ]
            ,400);
        }
    }
}
