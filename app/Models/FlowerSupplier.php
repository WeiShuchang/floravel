<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlowerSupplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'supplier_id',
        'flower_id',
        'price',
        'stocks',
    ];

    public function flower()
    {
        return $this->belongsTo(Flower::class, 'flower_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
