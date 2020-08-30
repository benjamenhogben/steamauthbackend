<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SteamAuth extends Controller
{
    const STEAM_LOGIN = 'https://steamcommunity.com/openid/login';
//    const API_KEY = config('app.steam_auth_key');

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        return response()->json(['data' => ['hello world']], 201);
    }
}
