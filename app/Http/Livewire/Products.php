<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Cart;
use App\Models\Orderp;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Products extends Component
{
    public $customer_name;
    public $customer_table;
    public $productid;
    public $productname;
    public $productprice;
    public $quantity;
    public $valid;

    public function render()
    {
        $this->totalprice = Cart::join('products', 'products.id', '=', 'cart.product_id')
            ->sum(DB::raw('quantity * price'));
        $this->totalquantity = Cart::join('products', 'products.id', '=', 'cart.product_id')
            ->sum('quantity');
        return view('livewire.products', [
            'carts' => Cart::with('getproduct')->get(),
            'products' => Product::all(),
        ]);
    }

    public function pesan()
    {
        $this->validate([
            'customer_name' => 'required',
        ]);
        $order = Order::create([
            'customer_name' => $this->customer_name,
            'customer_table' => $this->customer_table,
            'user_id' => Auth::user()->id,
            'total' => $this->totalprice
        ]);
        $carts = Cart::get();
        foreach ($carts as $cart) {
            $order->products()->attach($cart->product_id, [
                'quantity' => $cart->quantity,
            ]);
        }
        Cart::truncate();
    }

    public function tambahmenu($id)
    {
        $test = Product::findOrFail($id);
        $this->productid = $id;
        $this->productname = $test->name;
        $this->productprice = $test->price;
    }

    public function simpancart()
    {
        $this->validate([
            'quantity' => 'required',
        ]);
        Cart::create([
            'quantity' => $this->quantity,
            'product_id' => $this->productid
        ]);
        $this->resetInput();
    }

    public function resetInput()
    {
        $this->quantity = null;
    }

    public function destroy($id)
    {
        $record = Cart::where('id', $id);
        $record->delete();
    }
}
