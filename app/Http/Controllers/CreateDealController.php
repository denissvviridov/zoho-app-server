<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CreateDealController extends Controller
{
    public function CreateDeal(Request $request)
    {

        $accessToken = $request->input('accessToken');
        $zohoApiUrl = 'https://www.zohoapis.eu/crm/v2/';


        if ($accessToken) {

            $validatedData = $request->validate([
                'dealName' => 'required|string|max:255',
                'dealStage' => 'required|in:Prospecting,Qualification',
                'closingDate' => 'required|date',
                'accountName' => 'required|string|max:255',
                'accountWebsite' => 'required|string|max:255',
                'accountPhone' => 'required|string|max:20',
            ]);

            $dataDeal = [
                'data' => [
                    [
                    'Deal_Name' => (string)$validatedData['dealName'],
                    'Stage' => (string)$validatedData['dealStage'],
                    'Closing_Date' => (string)$validatedData['closingDate'],
                    'Account_Name' => (string)$validatedData['accountName'],
                    ]
                ]
            ];

            $dataAccount = [
                'data' => [
                    [
                    'Account_Name' => (string)$validatedData['accountName'],
                    'Website' => (string)$validatedData['accountWebsite'],
                    'Phone' => (string)$validatedData['accountPhone'],
                    ]
                ]
            ];

            $responseAccount = Http::withHeaders([
                'Authorization' => "Bearer $accessToken",
                'Content-Type' => 'application/json',
            ])->post($zohoApiUrl . 'Accounts', $dataAccount);


            if ($responseAccount->successful()) {

                $responseDeal = Http::withHeaders([
                    'Authorization' => "Bearer $accessToken",
                    'Content-Type' => 'application/json'
                ])->post($zohoApiUrl . 'Deals', $dataDeal);

                if ($responseDeal->successful()) {
                    return response()->json(['success' => 'Account and deal successfully created']);
                }
            } else {
                $errorDetails = $responseAccount->json();
                return response()->json(['error' => 'Error with adding an account and deal']);
            }
        }
    }
}
