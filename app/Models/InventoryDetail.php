<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryDetail extends Model
{
    use HasFactory;
    protected $fillable = ['inventory_id', 'product_id', 'unit_id', 'color', 'quantity'];

    public function inventory(){
        return $this->belongsTo(Inventory::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function unit(){
        return $this->belongsTo(Unit::class);
    }


}
