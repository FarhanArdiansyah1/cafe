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
            'students' => $this->students,
        ]);
    }

    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->checked = $this->students->pluck('id')->map(fn ($item) => (string) $item)->toArray();
        } else {
            $this->checked = [];
        }
    }

    public function updatedChecked()
    {
        $this->selectPage = false;
    }

    public function selectAll()
    {
        $this->selectAll = true;
        $this->checked = $this->studentsQuery->pluck('id')->map(fn ($item) => (string) $item)->toArray();
    }

    public function getStudentsProperty()
    {
        return $this->studentsQuery->paginate($this->paginate);
    }

    public function getStudentsQueryProperty()
    {
        return Product::search(trim($this->search));
    }

    public function deleteRecords()
    {
        User::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->selectAll = false;
        $this->selectPage = false;
        session()->flash('info', 'Selected Records were deleted Successfully');
    }

    public function deleteSingleRecord($student_id)
    {
        $student = User::findOrFail($student_id);
        $student->delete();
        $this->checked = array_diff($this->checked, [$student_id]);
        session()->flash('info', 'Record deleted Successfully');
    }

    public function isChecked($student_id)
    {
        return in_array($student_id, $this->checked);
    }

    public function simpanmenu(){
        $this->validate([
            'productname' => 'required',
            'price' => 'required'
        ]);
        Product::create([
            'name' => $this->productname,
            'price' => $this->price,
            'image' => $this->image->store('image')
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
