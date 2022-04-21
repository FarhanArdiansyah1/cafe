<?php

namespace App\Http\Livewire;

use App\Models\Order as Orderr;
use App\Models\Cart;
use App\Models\Orderp;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Order extends Component
{
    public $customer_name;
    public $customer_table;
    public $productid;
    public $productname;
    public $productprice;
    public $quantity;
    public $valid;
    public $productimage;

    public function render()
    {
        $this->totalprice = Cart::join('products', 'products.id', '=', 'cart.product_id')
            ->sum(DB::raw('quantity * price'));
        $this->totalquantity = Cart::join('products', 'products.id', '=', 'cart.product_id')
            ->sum('quantity');
        return view('livewire.order', [
            'carts' => Cart::with('getproduct')->get(),
            'products' => Product::all(),
        ]);
    }

    public function pesan()
    {
        $this->validate([
            'customer_name' => 'required',
        ]);

        if (empty($this->customer_table)) {
            $this->customer_table = 'di bungkus';
        }

        $order = Orderr::create([
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
        $product = Product::findOrFail($id);
        $this->productid = $id;
        $this->productname = $product->name;
        $this->productprice = $product->price;
        $this->productimage = $product->image;
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
