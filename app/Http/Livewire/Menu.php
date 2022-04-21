<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;



class Menu extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $paginate = 10;
    public $search = "";
    public $checked = [];
    public $selectPage = false;
    public $selectAll = false;
    protected $paginationTheme = 'bootstrap';
    public $price;
    public $productname;
    public $productid;
    public $image;
    


    public function render()
    {
        return view('livewire.menu', [
            'orders' => $this->orders,
        ]);
    }

    public function getOrdersProperty()
    {
        return $this->ordersQuery->paginate($this->paginate);
    }

    public function getOrdersQueryProperty()
    { 
        return Product::search(trim($this->search));
    }

    public function simpanmenu(){
        $this->validate([
            'productname' => 'required',
            'price' => 'required',
            'image' =>'required|image'
        ]);
        Product::create([
            'name' => $this->productname,
            'price' => $this->price,
            'image' => $this->image->store('images')
        ]);
        $this->resetInput();
    }

    public function simpanedit(){
        $this->validate([
            'productname' => 'required',
            'price' => 'required'
        ]);
        $record = Product::find($this->productid);
        $record->update([
            'name' => $this->productname,
            'price' => $this->price
        ]);
        $this->resetInput();
    }

    public function resetInput()
    {
        $this->productname = null;
        $this->price = null;
        $this->image = null;
    }

    public function destroy($id)
    {
        $record = Product::where('id', $id);
        $record->delete();
    }

    public function edit($id)
    {
        $record = Product::findOrFail($id);
        $this->productid = $id;
        $this->productname = $record->name;
        $this->price = $record->price;
    }
}
