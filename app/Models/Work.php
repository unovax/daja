<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'total',
        'paid',
        'balance',
        'status',
        'type',
        'description',
        'date'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function work_details()
    {
        return $this->hasMany(WorkDetail::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'work_details');
    }



}
