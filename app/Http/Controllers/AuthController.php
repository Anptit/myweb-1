<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function loginWithGoogle()
    {
        $url = 'https://accounts.google.com/o/oauth2/auth?';
        $params = [
            'client_id' => env('CLIENT_ID'),
            'redirect_uri' => 'http://127.0.0.1:8000/api/auth/google/handle',
            'response_type' => 'code',
            'scope' => 'https://www.googleapis.com/auth/gmail.readonly',
            'access_type' => 'offline',
        ];

        return redirect($url . http_build_query($params));
    }

    public function handleRequestToken(Request $request)
    {
        $uri = 'https://oauth2.googleapis.com/token?';
        $params = [
            'client_id' => env('CLIENT_ID'),
            'client_secret' => env('CLIENT_SECRET'),
            'code' => $request['code'],
            'grant_type' => 'authorization_code',
            'redirect_uri' => 'http://127.0.0.1:8000/api/auth/google/handle'
        ];
        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post($uri, $params);
        return $response->status();
    }
}
