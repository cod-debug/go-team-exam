<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; #for encryption 
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiToken;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create User
     * @param Request $request
     * @return User 
     */
    public function register(Request $request)
    {
        try {
            // Validated
            $validateUser = Validator::make($request->all(),
            [
                'first_name' => 'required',
                'middle_name' => '',
                'last_name' => 'required',
                'hobbies' => 'required',
                'birthdate' => 'required',
                'email' => 'required|email|unique:users,email',
                'username' => 'required|unique:users,username',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status_code' => 400,
                    'message' => 'Validation error!!!',
                    'errors' => $validateUser->errors()
                ], 400);
            }

            $user = User::create([
                ...$request->all(),
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */

    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'email' => 'required',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password'])) && !Auth::attempt($request->only(['username', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->orWhere('username', $request->username)->first();

            return response()->json([
                'status' => 'success',
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function index(){
        $users = User::all();
        return response()->json([
            'data' => $users
        ], 200);
    }

    public function create(){
        return response()->json([
            'message' => "created"
        ], 200);
    }
}
