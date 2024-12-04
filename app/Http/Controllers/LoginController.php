<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class LoginController extends Controller
{
    public function signup(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return Response::json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return Response::json([
            'success' => true,
            'message' => 'Регистрация прошла успешно',
            'user' => $user
        ], 201);
    }
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:3',
        ]);
        if ($validator->fails()) {
            return Response::json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        if (!Auth::attempt($request->only('email', 'password'))) {
            return Response::json([
                'success' => false,
                'message' => 'Неверный email или пароль',
            ], 401);
        }
        $user = Auth::user();

        $token = $user->createToken('auth_token')->plainTextToken;
        $info = [
            'name' => $user->name,
            'email' => $user->email,
        ];

        return Response::json([
            'success' => true,
            'message' => 'Успешный вход',
            'token' => $token,
            'user' => $info,
        ], 200);
    }
}
