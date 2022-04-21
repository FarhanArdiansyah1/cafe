<?php

namespace App\Http\Livewire;

use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;


class Users extends Component
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
    public $role_id;
    public $email, $password, $name, $iduser, $roleids, $roleid;
    


    public function render()
    {
        return view('livewire.users', [
            'users' => $this->users,
        ]);
    }

    public function getUsersProperty()
    {
        return $this->usersQuery->paginate($this->paginate);
    }

    public function getUsersQueryProperty()
    {
        return RoleUser::search(trim($this->search))->where('user_id', '!=', Auth::user()->id);
    }

    public function simpanmenu(){
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required'],
            'role_id' => ['required']
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role_id
        ]);

        $user->attachRole($this->role_id);

    }

    public function resetInput()
    {
        $this->name = null;
        $this->email = null;
        $this->role_id= null;
        $this->role_ids= null;
        $this->password= null;
    }

    public function destroy($id)
    {
        $role = RoleUser::where('user_id', $id);
        $role->delete();
        $user = User::where('id', $id);
        $user->delete();
    }

    public function edit($id)
    {
        $record = User::findOrFail($id);
        $this->iduser = $id;
        $this->name = $record->name;
        $this->email = $record->email;
        $role_ids = RoleUser::where('user_id', $id)->value('role_id');
        $this->role_id = Role::where('id', $role_ids)->value('name');

    }

    public function simpanedit(){
        $this->validate([
            'name' => ['required'],
            'email' => ['required'],
        ]);
        $record = User::find($this->iduser);
        $record->update([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),

        ]);
        $role_ids = Role::where('name', $this->role_id)->value('id');

        $updaterole = RoleUser::where('user_id', $this->iduser);
        $updaterole->update([
            'role_id' => $role_ids

        ]);
        $this->resetInput();
    }
}
