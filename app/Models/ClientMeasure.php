<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientMeasure extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'quantity', 'unit_id', 'client_id', 'measure_id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function measure()
    {
        return $this->belongsTo(Measure::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }


}
