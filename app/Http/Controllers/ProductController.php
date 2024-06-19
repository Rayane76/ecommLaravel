<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        try {

            // $products = Product::query()->paginate(2);
            // $productsData = $products->items();

            // return $productsData;
            // returns depending on pagination and on /product?page=4

            $products = Product::all();

            return $products;

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'title' => ['required', 'string'],
                'price' => ['required', 'decimal:2,8'],
                'added_by' => ['required', 'integer'],
            ]);
    
            Product::create($data);
    
            return response()->json(['message' => 'success'], 200);


        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {

        try {

            return $product;

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        try {
            $data = $request->validate([
                'title' => ['sometimes','required', 'string'],
                'price' => ['sometimes','required', 'decimal:2,8'],
                'added_by' => ['required', 'integer'],
            ]);
    
            $product->update($data);
    
            return response()->json(['message' => 'success'], 200);


        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();

            return response()->json(['message' => 'success'], 200);
            
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    
    }
}
