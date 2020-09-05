<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use LightOpenID;

class SteamAuth extends Controller
{
    const PATTERN = "~openid/id/\K\d+~";
    const STEAM_LOGIN = 'https://steamcommunity.com/openid';
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $apiKey;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $steamAuthUrl;
    /**
     * @var LightOpenID
     */
    private $openid;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $appUrl;

    public function __construct()
    {
        $this->apiKey  = config('app.steam.auth_key');
        $this->steamAuthUrl = config('app.steam.openid');
        $this->appUrl = config('app.url');
    }

    public function steamCallback()
    {
        $this->openid = new LightOpenID($this->appUrl . '/api/steamAuth/');
        if (
            $this->openid->validate() ||
            preg_match(self::PATTERN, $this->openid->identity, $matches)
        ) {
            preg_match(self::PATTERN, $this->openid->identity, $matches);
            return response()->json(['data' => [
                'steamId' => $matches[0]
            ]], 200);
        }
        return response()->json(['data' => [
            'error' => "Sorry, could not confirm Steam login, please try again"
        ]], 500);
    }

    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request)
    {
        try {
            $this->openid = new LightOpenID($this->appUrl . '/api/steamAuth/');
            $this->openid->returnUrl = $this->appUrl . "/api/steamAuth/callback";
            $this->openid->identity = self::STEAM_LOGIN;
            return \Redirect::to($this->openid->authUrl());
        } catch (\ErrorException $e) {
            return response()->json(['data' => [
                "error" => $e->getMessage()
            ]], 501);
        }
    }
}
