<?php

namespace App\Livewire\Client;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Maneuver;
use App\Models\Client;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class ManeuversTable extends Component
{
    use WithPagination;

    public $status = '';
    public $client_id = '';
    public $dateFrom = '';
    public $dateTo = '';
    
    protected $queryString = [
        'status' => ['except' => ''],
        'client_id' => ['except' => ''],
        'dateFrom' => ['except' => ''],
        'dateTo' => ['except' => ''],
    ];

    public function resetFilters()
    {
        $this->reset(['status', 'client_id', 'dateFrom', 'dateTo']);
        $this->resetPage();
    }

    public function render()
    {
        $query = Maneuver::with('client')
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->client_id, function ($query) {
                $query->where('client_id', $this->client_id);
            })
            ->when($this->dateFrom && $this->dateTo, function ($query) {
                $from = Carbon::parse($this->dateFrom)->startOfDay();
                $to = Carbon::parse($this->dateTo)->endOfDay();
                $query->whereBetween('created_at', [$from, $to]);
            })
            ->latest();

        $maneuvers = $query->paginate(10);

        $clients = User::orderBy('name')->get();
        $statuses = Maneuver::select('status')->distinct()->pluck('status');
        $products = Product::all();

        return view('livewire.client.maneuvers-table', [
            'maneuvers' => $maneuvers,
            'clients' => $clients,
            'products' => $products,
            'statuses' => $statuses,
            'presentations' => config('app.presentations')
        ]);
    }
}
