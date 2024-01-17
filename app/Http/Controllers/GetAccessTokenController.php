<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GetAccessTokenController extends Controller
{

     public function redirectToZoho()
    {
        return redirect()->away('https://accounts.zoho.com/oauth/v2/auth?scope=ZohoCRM.modules.ALL&client_id=1000.5Y3XAHM4OY62F5DOPA6PWEW5NVXJHI&redirect_uri=http://localhost:5173/create-deal&response_type=code&access_type=offline');
    }

    public function getAccessToken(Request $request)
    {
        $code = $request->input('code');

        $response = Http::asForm()->post('https://accounts.zoho.eu/oauth/v2/token', [
            'client_id' => '1000.5Y3XAHM4OY62F5DOPA6PWEW5NVXJHI',
            'client_secret' => '1500ebddf21cd3e02d90ae42730b0353e1676cf414',
            'redirect_uri' => 'http://localhost:5173/create-deal',
            'grant_type' => 'authorization_code',
            'code' => $code,

        ]);
    
        $tokenResponse = $response->json();
        return response()->json($tokenResponse);
    }

    public function refreshAccessToken(Request $request)
    {
        $refreshToken = $request->input('refreshToken');

        $response = Http::asForm()->post('https://accounts.zoho.eu/oauth/v2/token', [
            'client_id' => '1000.5Y3XAHM4OY62F5DOPA6PWEW5NVXJHI',
            'client_secret' => '1500ebddf21cd3e02d90ae42730b0353e1676cf414',
            'refresh_token' => $refreshToken,
            'grant_type' => 'refresh_token',
        ]);

        return $response->json();
    }


}
