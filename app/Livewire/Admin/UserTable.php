<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserTable extends Component
{
    use WithPagination;

    public $search = "";
    public $sort = "id";
    public $direction = "asc";
    public $perPage = 10;

    public function order($value)
    {
        if ($this->sort == $value) {
            $this->direction == "asc" ? "desc" : "asc";
        } else {
            $this->sort = $value;
            $this->direction = 'asc';
        }
    }

    public function render()
    {
        $users = User::where('name', 'like', '%' . $this->search . '%')->orWhere('email', 'like', '%' . $this->search . '%')->orderBy($this->sort, $this->direction)->paginate($this->perPage);
        return view('livewire.admin.user-table', compact('users'));
    }
}
