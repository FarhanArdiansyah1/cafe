<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Orderp;
use App\Models\Product;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class Orders extends Component
{
    use WithPagination;
    public $paginate = 10;
    public $search = "";
    public $checked = [];
    public $selectPage = false;
    public $selectAll = false;
    protected $paginationTheme = 'bootstrap';


    public function render()
    {
        $aday = Carbon::today()->addDays(1)->toDateString();
        $nowaday = Carbon::today()->toDateString();
        $this->harian = Order::where('created_at', '>=', $nowaday)->where('created_at', '<', $aday)->sum('total');
        $amonth = Carbon::parse($nowaday)->endOfMonth()->toDateString();
        $nowamonth = Carbon::parse($nowaday)->startOfMonth()->toDateString();;
        $this->bulanan = Order::where('created_at', '>=', $nowamonth)->where('created_at', '<', $amonth)->sum('total');
        return view('livewire.orders', [
            'orders' => $this->orders,
            'products' => Product::all(),
            'orderproducts' => Orderp::all(),
        ]);
    }

    public function getOrdersProperty()
    {
        return $this->ordersQuery->paginate($this->paginate);
    }

    public function getOrdersQueryProperty()
    {
        if (Auth::user()->role == 'kasir') {
            return Order::with(['getuser'])->where('user_id', '=', Auth::user()->id)->search(trim($this->search));
        } else {
            return Order::with(['getuser'])->search(trim($this->search));
        }
    }
}
