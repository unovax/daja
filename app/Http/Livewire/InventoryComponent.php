<?php

namespace App\Http\Livewire;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Ubication;
use App\Models\Unit;
use Livewire\Component;

class InventoryComponent extends Component
{
    public $products = [];
    public $units = [];
    public $ubications = [];

    public $inventory = [
        'id' => '',
        'ubication_id' => '',
        'date' => ''
    ];
    public $inventory_details = [];
    public $product_name = '';
    public $inventoryModal = false;
    public $deleteInventoryModal = false;

    public $ubicationModal = false;
    public $ubication = [
        'id' => '',
        'name' => '',
        'code' => ''
    ];

    protected $rules = [
        'inventory.id' => 'nullable',
        'inventory.ubication_id' => 'required',
        'inventory.date' => 'required|date',
        'inventory_details.*.id' => 'nullable',
        'inventory_details.*.product_id' => 'required|max:255',
        'inventory_details.*.unit_id' => 'required',
        'inventory_details.*.color' => 'required|max:10',
        'ubication.id' => 'nullable',
        'ubication.name' => 'required|max:255',
        'ubication.code' => 'required|max:10'
    ];

    protected $listeners = ['addProduct'];

    public $size_page = 100;
    public $search = null;

    public function render()
    {
        if($this->search){
            $inventories = Inventory::where('folio', 'like', '%'.$this->search.'%')
                ->orWhere('date', 'like', '%'.$this->search.'%')
                ->orWhereHas('ubication', function($query){
                    $query->where('name', 'like', '%'.$this->search.'%');
                })
                ->paginate($this->size_page)->onEachSide(-1);
        }
        else{
            $inventories = Inventory::paginate($this->size_page)->onEachSide(-1);
        }
        return view('livewire.inventory-component', [
            'inventories' => $inventories
        ]);
    }

    public function mount()
    {
        $this->units = Unit::all();
        $this->ubications = Ubication::all();
    }

    public function searchProducts(){
        if($this->product_name){
            $this->products = Product::where('name', 'like', '%'.$this->product_name.'%')->get();
        }
        else{
            $this->products = [];
        }
    }

    public function addProduct($index)
    {
        $product_id = $this->products[$index]->id;
        $hasAdded = array_search($product_id, array_column($this->inventory_details, 'product_id'));
        if ($hasAdded !== false) {
            $this->inventory_details[$hasAdded]['quantity'] += 1;
        } else {
            $this->inventory_details[] = [
                'product' => $this->products[$index],
                'product_id' => $product_id,
                'unit_id' => "",
                'color' => "",
                'quantity' => 1,
            ];
        }
        $this->product_name = '';
        $this->products = [];
        $this->emit('nextInput', $index);
    }

    public function setInventoryToEdit($id){
        $this->inventoryModal = true;
        $this->inventory = Inventory::find($id)->toArray();
        $this->inventory_details = Inventory::find($id)->inventory_details->load('product')->toArray();
    }

    public function saveInventory(){
        if($this->inventory['id']){
            $this->updateInventory();
        }
        else{
            $this->createInventory();
        }
    }

    public function createInventory(){
        $this->validate([
            'inventory.id' => 'nullable',
            'inventory.ubication_id' => 'required',
            'inventory.date' => 'required|date',
            'inventory_details' => 'array|min:1',
            'inventory_details.*.id' => 'nullable',
            'inventory_details.*.quantity' => 'required|max:255',
            'inventory_details.*.product_id' => 'required|max:255',
            'inventory_details.*.unit_id' => 'required',
            'inventory_details.*.color' => 'required|max:10',
        ]);
        $inventory = Inventory::create($this->inventory);
        foreach($this->inventory_details as $detail){
            $inventory->inventory_details()->create([
                'product_id' => $detail['product_id'],
                'unit_id' => $detail['unit_id'],
                'color' => $detail['color'],
                'quantity' => $detail['quantity']
            ]);
        }
        $this->erase();
        $this->emit('alert', ['type' => 'success', 'message' => 'Inventory created successfully']);
    }

    public function updateInventory(){
        $this->validate([
            'inventory.id' => 'nullable',
            'inventory.ubication_id' => 'required',
            'inventory.date' => 'required|date',
            'inventory_details' => 'array|min:1',
            'inventory_details.*.id' => 'nullable',
            'inventory_details.*.quantity' => 'required|max:255',
            'inventory_details.*.product_id' => 'required|max:255',
            'inventory_details.*.unit_id' => 'required',
            'inventory_details.*.color' => 'required|max:10',
        ]);
        $inventory = Inventory::find($this->inventory['id']);
        $inventory->update($this->inventory);
        foreach($this->inventory_details as $detail){
            if(isset($detail['id'])){
                $inventory->inventory_details()->find($detail['id'])->update([
                    'product_id' => $detail['product_id'],
                    'unit_id' => $detail['unit_id'],
                    'color' => $detail['color'],
                    'quantity' => $detail['quantity']
                ]);
            }
            else{
                $inventory->inventory_details()->create([
                    'product_id' => $detail['product_id'],
                    'unit_id' => $detail['unit_id'],
                    'color' => $detail['color'],
                    'quantity' => $detail['quantity']
                ]);
            }
        }
        $this->erase();
        $this->emit('showNotification', 'Inventario actualizado correctamente', 'success');
    }

    public function createUbication(){
        $this->validate([
            'ubication.name' => 'required|max:255',
            'ubication.code' => 'required|unique:ubications,code|max:10',
        ]);
        try {
            $ubication = Ubication::create($this->ubication);
            $this->emit('showNotification', 'Ubicacion guardada correctamente', 'success');
            $this->ubications = Ubication::all();
            $this->inventory['ubication_id'] = $ubication->id;
            $this->eraseUbicationData();
        } catch (\Throwable $th) {
            $this->emit('showNotification', $th->getMessage(), 'fail');
        }
    }

    public function eraseUbicationData(){
        $this->ubicationModal = false;
        $this->ubication = [
            'id' => '',
            'name' => '',
            'code' => ''
        ];
    }

    public function erase(){
        $this->inventoryModal = false;
        $this->products = [];
        $this->inventory_details = [];
        $this->deleteInventoryModal = false;
        $this->inventory = [
            'id' => '',
            'ubication_id' => '',
            'date' => ''
        ];
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
