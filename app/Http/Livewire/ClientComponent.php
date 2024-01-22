<?php

namespace App\Http\Livewire;

use App\Models\Client;
use Livewire\Component;

class ClientComponent extends Component
{
    public $clientModal = false;
    public $client = [
        'id' => '',
        'name' => '',
        'code' => '',
        'phone' => '',
        'address' => '',
    ];

    protected $rules = [
        'client.id' => 'nullable',
        'client.name' => 'required',
        'client.code' => 'required',
        'client.phone' => 'nullable',
        'client.address' => 'nullable',
    ];

    public $size_page = 100;

    public function render()
    {
        return view('livewire.client-component', [
            'clients' => Client::paginate($this->size_page)
        ]);
    }

    public function saveClient(){
        $this->validate();
        try {
            if($this->client['id'] == ''){
                Client::create($this->client);
            }else{
                Client::find($this->client['id'])->update($this->client);
            }
            $this->erase();

        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function erase(){
        $this->clientModal = false;
        $this->client = [
            'id' => '',
            'name' => '',
            'code' => '',
            'phone' => '',
            'address' => '',
        ];
    }
}
