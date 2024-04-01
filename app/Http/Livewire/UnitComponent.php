<?php

namespace App\Http\Livewire;

use App\Models\Unit;
use Livewire\Component;

class UnitComponent extends Component
{
    public $unitModal = false;
    public $deleteUnitModal = false;
    public $unit = [
        'id' => '',
        'name' => '',
        'code' => ''
    ];

    protected $rules = [
        'unit.id' => 'nullable',
        'unit.name' => 'required|max:255',
        'unit.code' => 'required|max:10'
    ];

    public $size_page = 100;
    public $search = null;

    public function render()
    {
        if($this->search){
            $units = Unit::where('name', 'like', '%'.$this->search.'%')
                ->orWhere('code', 'like', '%'.$this->search.'%')
                ->paginate($this->size_page)->onEachSide(-1);
        }
        else{
            $units = Unit::paginate($this->size_page)->onEachSide(-1);
        }
        return view('livewire.unit-component', [
            'units' => $units
        ]);
    }

    public function saveUnit(){
        if($this->unit['id'] == ''){
            $this->createUnit();
        }else{
            $this->updateUnit();
        }
    }

    public function createUnit(){
        $this->validate([
            'unit.name' => 'required|max:255',
            'unit.code' => 'required|unique:units,code|max:10',
        ]);
        try {
            Unit::create($this->unit);
            $this->emit('showNotification', 'Unidad guardada correctamente', 'success');
            $this->erase();
        } catch (\Throwable $th) {
            $this->emit('showNotification', $th->getMessage(), 'fail');
        }
    }

    public function updateUnit(){
        $this->validate([
            'unit.name' => 'required|max:255',
            'unit.code' => 'required|max:10|unique:units,code,'.$this->unit['id'],
        ]);
        try {
            Unit::find($this->unit['id'])->update($this->unit);
            $this->emit('showNotification', 'Unidad guardada correctamente', 'success');
            $this->erase();
        } catch (\Throwable $th) {
            $this->emit('showNotification', $th->getMessage(), 'fail');
        }
    }

    public function setUnitToEdit($id){
        $this->unitModal = true;
        $this->unit = Unit::find($id)->toArray();
    }

    public function setUnitToDelete($id){
        $this->deleteUnitModal = true;
        $this->unit = Unit::find($id)->toArray();
    }

    public function deleteUnit(){
        try {
            Unit::destroy($this->unit['id']);
            $this->emit('showNotification', 'Unidad eliminado correctamente', 'success');
            $this->erase();
        } catch (\Throwable $th) {
            $this->emit('showNotification', $th->getMessage(), 'fail');
        }
    }

    public function erase(){
        $this->unitModal = false;
        $this->deleteUnitModal = false;
        $this->unit = [
            'id' => '',
            'name' => '',
            'code' => ''
        ];
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
