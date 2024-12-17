<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class GHNController extends Controller
{
    /**
     * Get wards for a specific district from GHN API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWards(Request $request)
    {
        // Validate the request
        $request->validate([
            'district_id' => 'required|integer',
        ]);

        // Get the district ID from the request
        $districtId = $request->input('district_id');

        // GHN API endpoint
        $url = "https://online-gateway.ghn.vn/shiip/public-api/master-data/ward?district_id={$districtId}";

        // Initialize Guzzle client
        $client = new Client();

        try {
            // Make the API request to GHN
            $response = $client->get($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Token' => env('GHN_API_TOKEN'), // Use your GHN API token from .env
                ],
            ]);

            // Decode the JSON response
            $data = json_decode($response->getBody(), true);

            // Return the response data
            return response()->json($data);
        } catch (\Exception $e) {
            // Handle errors
            return response()->json([
                'error' => 'Failed to fetch data from GHN API',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
