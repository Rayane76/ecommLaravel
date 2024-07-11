<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;



class OrderController extends Controller implements HasMiddleware 
{
    public static function middleware(): array
    {
        return [
            new Middleware(['auth:sanctum', 'abilities:admin'],  except:['store'])
        ];
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $orders = Order::all();

            return $orders;

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
                'first_name' => ['required', 'string'],
                'last_name' => ['required', 'string'],
                'address' => ['required', 'string'],
                'tel' => ['required', 'string'],
                'product' => ['required','integer'],
            ]);


    
            Order::create($data);
    
            return response()->json(['message' => 'success'], 200);


        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        try {

            return $order;

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        try {
            $data = $request->validate([
                'status' => ['required','string',Rule::in(['Waiting','Confirmed','Canceled','Finished'])]
            ]);
    
            $order->update($data);
    
            return response()->json(['message' => 'success'], 200);


        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        try {
            $order->delete();

            return response()->json(['message' => 'success'], 200);
            
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
