<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Product;
use App\Models\Work;
use App\Models\WorkDetail;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class WorkComponent extends Component
{
    public $work = [
        'id' => '',
        'description' => '',
        'status' => 'P',
        'total' => 0,
        'paid' => 0,
        'balance' => 0,
        'client_id' => '',
        'client_name' => '',
        'type' => 'work',
    ];
    public $work_details = [];
    public $clients = [];
    public $products = [];

    public $workModal = false;
    public $clientModal = false;
    public $productModal = false;

    public $individual_dates;
    public $product_name;
    public $client_name;
    public $size_page = 100;
    public $search;

    protected $listeners = ['addProduct', 'setClient'];

    protected $rules = [
        'work.client_name' => 'required',
        'work.name' => 'required',
        'work.description' => 'required',
        'work.status' => 'required',
        'work.total' => 'required',
        'work.paid' => 'required',
        'work.balance' => 'required',
        'work.client_id' => 'required',
        'work_details.*.work_id' => 'required',
        'work_details.*.product_id' => 'required',
        'work_details.*.quantity' => 'required',
        'work_details.*.price' => 'required',
        'work_details.*.total' => 'required',
        'work_details.*.paid' => 'required',
        'work_details.*.balance' => 'required',
        'work_details.*.description' => 'required',
        'work_details.*.status' => 'required',
        'work_details.*.date' => 'nullable|date',
    ];

    public function searchClients(){
        if($this->client_name){
            $this->clients = Client::where('name', 'like', '%'.$this->client_name.'%')->get();
        }else{
            $this->clients = [];
        }
    }

    public function searchProducts(){
        if($this->product_name){
            $this->products = Product::where('name', 'like', '%'.$this->product_name.'%')->get();
        }else{
            $this->products = [];
        }
    }

    public function setClient($index){
        $this->work['client_id'] = $this->clients[$index]['id'];
        $this->work['client_name'] = $this->clients[$index]['name'];
        $this->clients = [];
    }

    public function setClientToNull(){
        $this->work['client_id'] = null;
        $this->work['client_name'] = null;
    }

    public function addProduct($index){
        $product_id = $this->products[$index]->id;
        $hasAdded = array_search($product_id, array_column($this->work_details, 'product_id'));
        if ($hasAdded !== false) {
            $this->work_details[$hasAdded]['quantity'] += 1;
        } else {
            $this->work_details[] = [
                'product' => $this->products[$index],
                'product_id' => $this->products[$index]->id,
                'quantity' => 1,
                'price' => null,
                'total' => null,
                'paid' => 0,
                'balance' => 0,
                'description' => null,
                'status' => 'P',
            ];
        }
        $this->product_name = '';
        $this->products = [];
        $this->emit('nextInput', $index);
    }

    public function render(){
        return view('livewire.work-component', [
            'work_detail_list' => WorkDetail::orderBy('date')->paginate($this->size_page),
        ]);
    }

    public function saveWork(){
        if($this->work['id']){
            $this->updateWork();
        }
        else{
            $this->createWork();
        }
    }

    public function createWork(){
        DB::beginTransaction();
        $this->validate([
            'work.client_id' => 'required',
            'work.description' => 'required',
            'work_details' => 'required|array|min:1',
            'work_details.*.product_id' => 'required',
            'work_details.*.quantity' => 'required',
            'work_details.*.price' => 'required',
            'work_details.*.description' => 'required',
            'work_details.*.status' => 'required',
            'work_details.*.date' => 'required_if:individual_dates,true|date',
        ]);
        try {
            $work = Work::create($this->work);
            $work->work_details()->createMany($this->work_details);
            $this->workModal = false;
            $this->work = [
                'id' => '',
                'name' => '',
                'description' => '',
                'status' => '',
                'total' => '',
                'paid' => '',
                'balance' => '',
                'client_id' => '',
                'client_name' => '',
            ];
            DB::commit();
            $this->erase();
            $this->work_details = [];
            $this->emit('showNotification', 'Trabajo creado correctamente', 'success');
        } catch (\Throwable $th) {
            $this->emit('showNotification', $th->getMessage(), 'fail');
            DB::rollBack();
        }
    }

    public function erase(){
        $this->work = [
            'id' => '',
            'name' => '',
            'description' => '',
            'status' => '',
            'total' => '',
            'paid' => '',
            'balance' => '',
            'client_id' => '',
            'client_name' => '',
        ];
        $this->work_details = [];
        $this->clients = [];
        $this->products = [];
        $this->product_name = '';
        $this->client_name = '';
        $this->search = '';
        $this->workModal = false;
    }
}
