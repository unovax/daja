<?php

namespace App\Http\Livewire;

use App\Models\Measure;
use Livewire\Component;

class MeasureComponent extends Component
{
    public $measureModal = false;
    public $deleteMeasureModal = false;
    public $measure = [
        'id' => '',
        'name' => '',
        'code' => ''
    ];

    protected $rules = [
        'measure.id' => 'nullable',
        'measure.name' => 'required|max:255',
        'measure.code' => 'required|max:10'
    ];

    public $size_page = 100;
    public $search = null;

    public function render()
    {
        if($this->search){
            $measures = Measure::where('name', 'like', '%'.$this->search.'%')
                ->orWhere('code', 'like', '%'.$this->search.'%')
                ->paginate($this->size_page)->onEachSide(-1);
        }
        else{
            $measures = Measure::paginate($this->size_page)->onEachSide(-1);
        }
        return view('livewire.measure-component', [
            'measures' => $measures
        ]);
    }

    public function saveMeasure(){
        if($this->measure['id'] == ''){
            $this->createMeasure();
        }else{
            $this->updateMeasure();
        }
    }

    public function createMeasure(){
        $this->validate([
            'measure.name' => 'required|max:255',
            'measure.code' => 'required|unique:measures,code|max:10',
        ]);
        try {
            Measure::create($this->measure);
            $this->emit('showNotification', 'Medida guardada correctamente', 'success');
            $this->erase();
        } catch (\Throwable $th) {
            $this->emit('showNotification', $th->getMessage(), 'fail');
        }
    }

    public function updateMeasure(){
        $this->validate([
            'measure.name' => 'required|max:255',
            'measure.code' => 'required|max:10|unique:measures,code,'.$this->measure['id'],
        ]);
        try {
            Measure::find($this->measure['id'])->update($this->measure);
            $this->emit('showNotification', 'Medida guardada correctamente', 'success');
            $this->erase();
        } catch (\Throwable $th) {
            $this->emit('showNotification', $th->getMessage(), 'fail');
        }
    }

    public function setMeasureToEdit($id){
        $this->measureModal = true;
        $this->measure = Measure::find($id)->toArray();
    }

    public function setMeasureToDelete($id){
        $this->deleteMeasureModal = true;
        $this->measure = Measure::find($id)->toArray();
    }

    public function deleteMeasure(){
        try {
            Measure::destroy($this->measure['id']);
            $this->emit('showNotification', 'Medida eliminado correctamente', 'success');
            $this->erase();
        } catch (\Throwable $th) {
            $this->emit('showNotification', $th->getMessage(), 'fail');
        }
    }

    public function erase(){
        $this->measureModal = false;
        $this->deleteMeasureModal = false;
        $this->measure = [
            'id' => '',
            'name' => '',
            'code' => ''
        ];
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
