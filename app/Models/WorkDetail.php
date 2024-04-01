<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_id',
        'product_id',
        'quantity',
        'price',
        'total',
        'paid',
        'balance',
        'description',
        'status',
        'date'
    ];

    public static function boot(){
        parent::boot();
        static::creating(function($work_detail){
            $work_detail->total = floatval($work_detail->quantity) * floatval($work_detail->price);
        });
    }

    public function work()
    {
        return $this->belongsTo(Work::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
