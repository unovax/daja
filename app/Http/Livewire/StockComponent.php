<?php

namespace App\Http\Livewire;

use App\Models\InventoryDetail;
use Livewire\Component;

class StockComponent extends Component
{

    public $size_page = 100;
    public $search = null;

    public function render()
    {
        if($this->search){
            $stocks = InventoryDetail::where('quantity', 'like', '%'.$this->search.'%')
                ->orWhereHas('product', function ($query) {
                    $query->where('name', 'like', '%'.$this->search.'%');
                })
                ->orWhereHas('unit', function ($query) {
                    $query->where('name', 'like', '%'.$this->search.'%');
                })
                ->orWhereHas('inventory', function ($query) {
                    $query->whereHas('ubication', function ($query) {
                        $query->where('name', 'like', '%'.$this->search.'%');
                    });
                })
                ->paginate($this->size_page)->onEachSide(-1);
        }
        else{
            $stocks = InventoryDetail::paginate($this->size_page)->onEachSide(-1);
        }
        return view('livewire.stock-component', [
            'stocks' => $stocks
        ]);
    }
}
