<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

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
    public function resetPassword(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return Response::json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return Response::json([
                'success' => false,
                'message' => 'Пользователь с таким email не найден',
            ], 404);
        }
        $token = Str::random(60);
        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );
        Mail::send('emails.password_reset', ['token' => $token], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Сброс пароля');
        });

        return Response::json([
            'success' => true,
            'message' => 'Ссылка для сброса пароля отправлена на ваш email',
        ], 200);
    }
    public function updatePassword(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return Response::json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $resetRequest = DB::table('password_resets')->where('token', $request->token)->first();
        if (!$resetRequest || !Hash::check($request->token, $resetRequest->token)) {
            return Response::json([
                'success' => false,
                'message' => 'Токен недействителен или истёк',
            ], 400);
        }
        $user = User::where('email', $resetRequest->email)->first();
        if (!$user) {
            return Response::json([
                'success' => false,
                'message' => 'Пользователь не найден',
            ], 404);
        }
        $user->password = Hash::make($request->password);
        $user->save();
        DB::table('password_resets')->where('email', $user->email)->delete();

        return Response::json([
            'success' => true,
            'message' => 'Пароль успешно обновлён',
        ], 200);
    }
}
