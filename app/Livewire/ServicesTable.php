<?php

namespace App\Livewire;

use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;

class ServicesTable extends Component
{

     use WithPagination;
    
    public $showModal = false;
    
    public function render()
    {
        return view('livewire.services-table', [
            'services' => Service::paginate(10)
        ]);
    }
    
    public function toggleModal()
    {
        $this->showModal = !$this->showModal;
    }
}
