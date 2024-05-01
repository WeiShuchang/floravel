<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Order.php
    public function flower()
    {
        return $this->belongsTo(Flower::class);
    }


}
