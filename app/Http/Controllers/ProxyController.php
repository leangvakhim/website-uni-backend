<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProxyController
{
    public function forward(Request $request, $path)
    {
        $method = strtolower($request->method());
        $url = "https://aimostore.shop/api/{$path}";

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json'
            ])->{$method}($url, $request->all());

            return response($response->body(), $response->status())
                ->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Proxy failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
