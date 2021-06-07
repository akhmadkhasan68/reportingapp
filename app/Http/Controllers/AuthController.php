<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        if(Auth::check())
        {
            redirect()->route('dashboard.index');
        }
    }

    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
            ],
            'password' => [
                'required',
            ],
        ]);

        if($validator->fails())
        {
            $errors = $validator->errors();

            return response()->json(['success' => false, 'message' => $errors]);
        }

        Auth::attempt(['email' => $request->email, 'password' => $request->password, 'type' => 'admin']);
        // return Auth::user();
        if(Auth::check())
        {
            return response()->json(['success' => true, 'message' => 'Berhasil melakukan login']);
        }
        else
        {
            return response()->json(['success' => false, 'message' => ['login' => ['Email dan Password tidak cocok!']]]);
        }
    }

    public function login_api(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
            ],
            'password' => [
                'required',
            ],
        ]);

        if($validator->fails())
        {
            $errors = $validator->errors();

            return response()->json(['success' => false, 'message' => $errors]);
        }

        $token = Auth::guard('api')->attempt(['email' => $request->email, 'password' => $request->password, 'type' => 'member']);
        // return Auth::user();
        if(!$token)
        {
            return response()->json(['success' => false, 'message' => ['login' => ['Email dan Password tidak cocok!']]]);
        }

        return $this->createNewToken($token);
    }

    public function logout()
    {
        Auth::logout(); // menghapus session yang aktif
        return response()->json(['message' => 'User successfully signed out']);
    }

    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => Auth::user()
        ]);
    }

    public function refresh() {
        return $this->createNewToken(Auth::refresh());
    }
}
