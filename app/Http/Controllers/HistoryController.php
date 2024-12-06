<?php

namespace App\Http\Controllers;

use App\Models\UserAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\PersonalAccessToken;

class HistoryController extends Controller
{
    public function get(Request $request)
    {
        $user = PersonalAccessToken::findToken($request->bearerToken())?->tokenable;
        $userActions = UserAction::where('user_id', $user->id)->get();

        return response()->json($userActions);
    }
}
