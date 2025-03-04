<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $apiUrl = "https://api.restful-api.dev/objects";

    public function productsPage(Request $request)
    {
        $response = Http::get('https://api.restful-api.dev/objects');
        $products = $response->json();
        return view('products.index', compact('products'));
    }

    public function createProduct(Request $request) {
        $response = Http::post($this->apiUrl, [
            'name' => $request['name'],
            'data' => [
                'price' => $request['price'],
                'color' => $request['color'],
            ]
        ]);

        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create product.',
                'error' => $response->json()
            ], $response->status());
        }
    
        return response()->json(['success' => true, 'message' => 'Product created successfully!']);
    }

    public function editProduct(Request $request, $id) {
        $response = Http::put("$this->apiUrl/$id", [
            'name' => $request['name'],
            'data' => [
                'price' => $request['price'],
                'color' => $request['color'],
            ]
        ]);     
        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product.',
                'error' => $response->json()
            ], $response->status());
        }  
        return redirect()->route('products.index');
    }
}
