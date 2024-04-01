<?php

namespace App\Http\Livewire;

use App\Models\Ubication;
use Livewire\Component;

class UbicationComponent extends Component
{
    public $ubicationModal = false;
    public $deleteUbicationModal = false;
    public $ubication = [
        'id' => '',
        'name' => '',
        'code' => ''
    ];

    protected $rules = [
        'ubication.id' => 'nullable',
        'ubication.name' => 'required|max:255',
        'ubication.code' => 'required|max:10'
    ];

    public $size_page = 100;
    public $search = null;

    public function render()
    {
        if($this->search){
            $ubications = Ubication::where('name', 'like', '%'.$this->search.'%')
                ->orWhere('code', 'like', '%'.$this->search.'%')
                ->paginate($this->size_page)->onEachSide(-1);
        }
        else{
            $ubications = Ubication::paginate($this->size_page)->onEachSide(-1);
        }
        return view('livewire.ubication-component', [
            'ubications' => $ubications
        ]);
    }

    public function saveUbication(){
        if($this->ubication['id'] == ''){
            $this->createUbication();
        }else{
            $this->updateUbication();
        }
    }

    public function createUbication(){
        $this->validate([
            'ubication.name' => 'required|max:255',
            'ubication.code' => 'required|unique:ubications,code|max:10',
        ]);
        try {
            Ubication::create($this->ubication);
            $this->emit('showNotification', 'Unidad guardada correctamente', 'success');
            $this->erase();
        } catch (\Throwable $th) {
            $this->emit('showNotification', $th->getMessage(), 'fail');
        }
    }

    public function updateUbication(){
        $this->validate([
            'ubication.name' => 'required|max:255',
            'ubication.code' => 'required|max:10|unique:ubications,code,'.$this->ubication['id'],
        ]);
        try {
            Ubication::find($this->ubication['id'])->update($this->ubication);
            $this->emit('showNotification', 'Unidad guardada correctamente', 'success');
            $this->erase();
        } catch (\Throwable $th) {
            $this->emit('showNotification', $th->getMessage(), 'fail');
        }
    }

    public function setUbicationToEdit($id){
        $this->ubicationModal = true;
        $this->ubication = Ubication::find($id)->toArray();
    }

    public function setUbicationToDelete($id){
        $this->deleteUbicationModal = true;
        $this->ubication = Ubication::find($id)->toArray();
    }

    public function deleteUbication(){
        try {
            Ubication::destroy($this->ubication['id']);
            $this->emit('showNotification', 'Unidad eliminado correctamente', 'success');
            $this->erase();
        } catch (\Throwable $th) {
            $this->emit('showNotification', $th->getMessage(), 'fail');
        }
    }

    public function erase(){
        $this->ubicationModal = false;
        $this->deleteUbicationModal = false;
        $this->ubication = [
            'id' => '',
            'name' => '',
            'code' => ''
        ];
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
