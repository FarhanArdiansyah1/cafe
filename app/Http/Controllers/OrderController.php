<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Orderp;
use Illuminate\Http\Request;
use App\Models\Product;

class OrderController extends Controller
{
    public function index()
    {
        return view('orders.create');
    }

    // public function create()
    // {
    // 	return view('orders.create');
    // }

    public function store(Request $request)
    {
        Order::create([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
        ]);

        foreach ($request->orderProducts as $product) {
            // $eta->products()->attach(
            //     $product['product_id'],
            //     ['quantity' => $product['quantity']]
            // );
            Orderp::create([
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
            ]);
        }

        return 'Order stored successfully!';
    }
}
