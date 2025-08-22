<?php

namespace App\Livewire\Toll;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Maneuver;
use App\Models\ManeuverFile;
use App\Models\ManeuverPayment;
use Illuminate\Support\Facades\Storage;

class TollManeuversTable extends Component
{
    use WithFileUploads;

    public $maneuvers;
    public $selectedManeuver;
    public $showModal = false;
    public $showModalMoney = false;
    public $ineFile;
    public $licenseFile;
    public $existingIne = null;
    public $existingLicense = null;
    public $cashAmount = ''; // Cantidad de efectivo
    public $paymentSuccess = false; 

    public $search = '';
    public $statusFilter = '';
    public $serviceTypeFilter = '';
    public $showModalNew = false;
    public $selectedServiceType = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'serviceTypeFilter' => ['except' => ''],
    ];

    public function mount()
    {
        $this->loadManeuvers();
    }

    public function loadManeuvers()
    {
        $this->maneuvers = Maneuver::whereDate('programming_date', today())
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function showUploadModal($maneuverId)
    {
        $this->selectedManeuver = Maneuver::findOrFail($maneuverId);
        $this->checkExistingFiles();
        $this->showModal = true;
    }

    public function showUploadMoneyModal($maneuverId)
    {
        $this->selectedManeuver = Maneuver::findOrFail($maneuverId);
        //$this->checkExistingFiles();
        $this->showModalMoney = true;
    }

    public function resetPaymentForm()
    {
        $this->reset(['cashAmount', 'paymentSuccess']);
        $this->resetErrorBag();
    }

    public function savePayment()
    {
        $this->validate([
            'cashAmount' => 'required|numeric|min:1'
        ]);

        // Registrar el pago
        ManeuverPayment::create([
            'maneuver_id' => $this->selectedManeuver->id,
            'amount' => $this->cashAmount,
            'payment_method' => 'efectivo',
            'status' => 'completa',
            'created_by' => auth()->user()->id,
        ]);

        $this->showModalMoney = false;
        //$this->loadManeuvers();
        
        // Cerrar automáticamente después de 2 segundos
        $this->dispatch('alert', [
           'type' => 'success',
           'title' => '¡Éxito!',
           'text' => 'Pago gaurdado correctamente'
       ]);
    }

    public function openModal()
    {
        $this->showModalNew = true;
    }

    public function closeModal()
    {
        $this->showModalNew = false;
        $this->selectedServiceType = '';
    }

    public function selectServiceType($type)
    {
        $this->selectedServiceType = $type;
        $this->closeModal();
        
        // Redirigir según el tipo de servicio seleccionado
        switch ($type) {
            case 'traslado':
                return redirect()->route('services.transfer.create');
            case 'almacenaje':
                return redirect()->route('services.storage.create');
            case 'maniobra':
                return redirect()->route('services.maneuver.create');
        }
    }

    public function closePaymentModal(){
        $this->showModalMoney = false;
        $this->reset(['cashAmount', 'paymentSuccess']);
        $this->resetErrorBag();
    }

    public function checkExistingFiles()
    {
        $this->existingIne = $this->getFileIfExists('ine');
        $this->existingLicense = $this->getFileIfExists('license');
    }

    public function checkIn($maneuverId)
    {
        $maneuver = Maneuver::findOrFail($maneuverId);
        $maneuver->check_in = now();
        $maneuver->user_check_in = auth()->user()->id;
        $maneuver->save();
        $this->loadManeuvers();
    }

    public function checkOut($maneuverId)
    {
        $maneuver = Maneuver::findOrFail($maneuverId);
        $maneuver->check_out = now();
        $maneuver->user_check_out = auth()->user()->id;
        $maneuver->save();
        $this->loadManeuvers();
    }

    protected function getFileIfExists($type)
    {
        $types = array("ine"=>"INE", "license"=>"Licencia de conducir");
        $file = ManeuverFile::where('maneuver_id', $this->selectedManeuver->id)
            ->where('type', $types[$type])
            ->first();
        $path = $file ? $file->path : "maneuvers/{$this->selectedManeuver->id}/{$type}";
        
        if (Storage::disk("public")->exists($path)) {
            return Storage::disk("public")->url($path);
        }
        
        return null;
    }

    public function closeFilesModal()
    {
        $this->showModal = false;
        $this->reset(['ineFile', 'licenseFile']);
    }

    public function uploadFiles()
    {
        $this->validate([
            'ineFile' => 'nullable|image|max:2048',
            'licenseFile' => 'nullable|image|max:2048'
        ]);

        if ($this->ineFile) {
            $this->uploadFile($this->ineFile, 'ine');

            $file = new ManeuverFile();
            $file->maneuver_id = $this->selectedManeuver->id;
            $file->type = 'INE';
            $file->path = "maneuvers/{$this->selectedManeuver->id}/ine.".$this->ineFile->getClientOriginalExtension();
            $file->file_extension = $this->ineFile->extension();
            $file->save();
        }

        if ($this->licenseFile) {
            $this->uploadFile($this->licenseFile, 'license');
            $file = new ManeuverFile();
            $file->maneuver_id = $this->selectedManeuver->id;
            $file->type = 'Licencia de conducir';
            $file->path = "maneuvers/{$this->selectedManeuver->id}/license.".$this->licenseFile->getClientOriginalExtension();
            $file->file_extension = $this->licenseFile->extension();
            $file->save();
        }

        $this->reset(['ineFile', 'licenseFile']);
        $this->checkExistingFiles();
        $this->emit('filesUploaded');
    }

    protected function uploadFile($file, $type)
    {
        $path = "maneuvers/{$this->selectedManeuver->id}";        
        //$file->store($path, 'public');
        Storage::disk('public')->putFileAs($path, $file, $type.".".$file->getClientOriginalExtension());
    }

    public function updateStatus($maneuverId)
    {
        $maneuver = Maneuver::findOrFail($maneuverId);
        $maneuver->update(['status' => 'En almacen']);
        $this->loadManeuvers();
    }

    public function render()
    {
        return view('livewire.toll.toll-maneuvers-table');
    }
}
