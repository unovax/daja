<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Measure;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ClientComponent extends Component
{
    public $clientModal = false;
    public $deleteClientModal = false;
    public $measureModal = false;
    public $measures = [];
    public $units = [];
    public $client_measures = [];
    public $measure_name = '';
    public $client = [
        'id' => '',
        'name' => '',
        'code' => '',
        'phone' => '',
        'address' => '',
    ];

    public $measure = [
        'id' => '',
        'name' => '',
        'code' => ''
    ];

    protected $rules = [
        'client.id' => 'nullable',
        'client.name' => 'required|max:255',
        'client.code' => 'required|max:10',
        'client.phone' => 'nullable|numeric|digits:10',
        'client.address' => 'nullable|max:255',
        'client_measures' => 'required|array|min:1',
        'client_measures.*.id' => 'nullable',
        'client_measures.*.measure_id' => 'required|max:255',
        'client_measures.*.name' => 'required|numeric',
        'client_measures.*.quantity' => 'required|numeric',
        'client_measures.*.unit_id' => 'required|numeric',
        'measure.id' => 'nullable',
        'measure.name' => 'required|max:255',
        'measure.code' => 'required|max:10'
    ];

    public $size_page = 100;
    public $search = null;

    protected $listeners = ['addItem' => 'addMeasure'];

    public function render()
    {
        if($this->search){
            $clients = Client::where('name', 'like', '%'.$this->search.'%')
                ->orWhere('code', 'like', '%'.$this->search.'%')
                ->orWhere('phone', 'like', '%'.$this->search.'%')
                ->orWhere('address', 'like', '%'.$this->search.'%')
                ->paginate($this->size_page)->onEachSide(-1);
        }
        else{
            $clients = Client::paginate($this->size_page)->onEachSide(-1);
        }
        return view('livewire.client-component', [
            'clients' => $clients
        ]);
    }

    public function mount(){
        $this->units = Unit::all();
    }

    public function searchMeasures(){
        if($this->measure_name){
            $this->measures = Measure::where('name', 'like', '%'.$this->measure_name.'%')->get();
        }
        else{
            $this->measures = [];
        }
    }

    public function addMeasure($index)
    {
        $measure_id = $this->measures[$index]->id;
        $hasAdded = array_search($measure_id, array_column($this->client_measures, 'measure_id'));
        if ($hasAdded !== false) {
            $this->client_measures[$hasAdded]['quantity'] += 1;
        } else {
            array_unshift(
                $this->client_measures,
                [
                    'measure' => $this->measures[$index],
                    'measure_id' => $measure_id,
                    'unit_id' => "",
                    'color' => "",
                    'quantity' => 1,
                ]
            );
        }
        $this->measure_name = '';
        $this->measures = [];
        $this->emit('nextInput', 'client_measures.0.quantity');
    }

    public function saveClient(){
        if($this->client['id'] == ''){
            $this->createClient();
        }else{
            $this->updateClient();
        }
    }

    public function createClient(){
        $this->validate([
            'client.name' => 'required|max:255',
            'client.code' => 'required|unique:clients,code|max:10',
            'client.phone' => 'nullable|numeric|digits:10',
            'client.address' => 'nullable|max:255',
            'client_measures' => 'nullable|array',
            'client_measures.*.id' => 'nullable',
            'client_measures.*.measure_id' => 'required|max:255',
            'client_measures.*.quantity' => 'required|numeric',
            'client_measures.*.unit_id' => 'required|numeric',

        ]);
        DB::beginTransaction();
        try {
            $client = Client::create($this->client);
            $client->client_measures()->createMany($this->client_measures);
            $this->emit('showNotification', 'Cliente guardado correctamente', 'success');
            $this->erase();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->emit('showNotification', $th->getMessage(), 'fail');
        }
    }

    public function setClientToEdit($id){
        $this->clientModal = true;
        $this->client = Client::find($id)->toArray();
        $this->client_measures = Client::find($id)->client_measures->load('measure')->toArray();
    }

    public function updateClient(){
        $this->validate([
            'client.name' => 'required|max:255',
            'client.code' => 'required|max:10|unique:clients,code,'.$this->client['id'],
            'client.phone' => 'nullable|numeric|digits:10',
            'client.address' => 'nullable|max:255',
        ]);
        DB::beginTransaction();
        try {
            $client = Client::find($this->client['id']);
            $client->update($this->client);
            foreach($this->client_measures as $cm){
                if(isset($cm['id'])){
                    $client->client_measures()->find($cm['id'])->update($cm);
                }
                else{
                    $client->client_measures()->create($cm);
                }
            }
            $this->emit('showNotification', 'Cliente guardado correctamente', 'success');
            $this->erase();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->emit('showNotification', $th->getMessage(), 'fail');
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
            $this->measures = Measure::all();
            $this->measure_name = $this->measure['name'];
            $this->searchMeasures();
            $this->emit('nextInput', 'measure_search_input');
            $this->eraseMeasureData();

        } catch (\Throwable $th) {
            $this->emit('showNotification', $th->getMessage(), 'fail');
        }
    }

    public function eraseMeasureData(){
        $this->measureModal = false;
        $this->measure = [
            'id' => '',
            'name' => '',
            'code' => ''
        ];
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function setClientToDelete($id){
        $this->deleteClientModal = true;
        $this->client = Client::find($id)->toArray();
    }

    public function deleteClient(){
        try {
            Client::destroy($this->client['id']);
            $this->emit('showNotification', 'Cliente eliminado correctamente', 'success');
            $this->erase();
        } catch (\Throwable $th) {
            $this->emit('showNotification', $th->getMessage(), 'fail');
        }
    }

    public function erase(){
        $this->clientModal = false;
        $this->deleteClientModal = false;
        $this->client = [
            'id' => '',
            'name' => '',
            'code' => '',
            'phone' => '',
            'address' => '',
        ];
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
