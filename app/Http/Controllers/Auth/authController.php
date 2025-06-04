<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class authController extends Controller
{
    // ✅ REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:users,nik',
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
            'no_telepon' => 'required|unique:users,no_telepon',
            'password' => 'required|min:6'
        ]);

        $form_data = [
            'nik' => $request->input('nik'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'no_telepon' => $request->input('no_telepon'),
            'password' => bcrypt($request->input('password')),
        ];

        if ($request->filled('role')) {
            $form_data['role'] = $request->input('role');
        }


        $user = User::create($form_data);

        return response()->json([
            'message' => 'register success',
        ]);
    }

    // ✅ LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'credentials' => 'required',
            'password' => 'required'
        ]);

        $input = $request->only(['credentials', 'password']);

        $user = User::where('nik', $input['credentials'])->orWhere('username', $input['credentials'])->first();

        if (!$user ) {
            return response()->json(['message' => 'Username atau NIK salah!'], 401);
        }

        if (!Hash::check($request->password, $user->password)){
            return response()->json(['message'=> 'Password salah'],401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'login success',
            'token' => $token,
        ]);
    }

    // ✅ LOGOUT
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'logout success']);
    }
}
