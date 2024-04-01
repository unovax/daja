<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $fillable = ['folio', 'date', 'ubication_id'];

    //funcion para crear folio automatico al momento de crear un inventario

    public static function boot(){
        parent::boot();
        static::creating(function($inventory){
            $inventory->folio = self::createFolio();
        });
    }

    public static function createFolio(){
        $last_folio = Folio::where('type', 'I')->first();
        $left_folio = str_pad($last_folio->prefix, 9 - strlen($last_folio->consecutive), '0');
        $folio = $left_folio . $last_folio->consecutive;
        $last_folio->consecutive++;
        $last_folio->save();
        return $folio;
    }

    public function ubication(){
        return $this->belongsTo(Ubication::class);
    }

    public function inventory_details(){
        return $this->hasMany(InventoryDetail::class);
    }

}
