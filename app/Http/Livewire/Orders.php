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
            'students' => $this->students,
            'products' => Product::all(),
            'orderproducts' => Orderp::all(),
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
        if (Auth::user()->role == 'kasir') {
            return Order::with(['getuser'])->where('user_id', '=', Auth::user()->id)->search(trim($this->search));
        } else {
            return Order::with(['getuser'])->search(trim($this->search));
        }
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

}
