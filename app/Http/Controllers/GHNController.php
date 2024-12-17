<?php

namespace App\Http\Controllers;

use App\Models\Team;
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
    public function getShippingFee(Request $request)
    {
        $request->validate([
            'team_id' => 'required|string',
            'to_district_id' => 'required|string',
            'to_ward_code' => 'required|string',
            'insurance_value' => 'required',
        ]);

        $client = new Client();
        $url = 'https://online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/fee';
        $team = Team::find($request->input('team_id'));
        try {
            $response = $client->post($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Token' => env('GHN_API_TOKEN'),
                ],
                'json' => [
                    'from_district_id' => (int) $team->state,
                    'from_ward_code' => $team->ward,
                    'service_id' => 53320,
                    'service_type_id' => $request->input('service_type_id'),
                    'to_district_id' => (int) $request->input('to_district_id'),
                    'to_ward_code' => $request->input('to_ward_code'),
                    'height' => 15,
                    'length' => 5,
                    'weight' => 50,
                    'width' => 15,
                    'insurance_value' => (int) $request->input('insurance_value'),
                    'cod_failed_amount' => 10000,
                    'coupon' => null,
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch shipping fee',
                'message' => $e->getMessage(),
            ], 500);
        }
    }}
