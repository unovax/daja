<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'code', 'phone', 'address'];

    public function client_measures()
    {
        return $this->hasMany(ClientMeasure::class);
    }
}
