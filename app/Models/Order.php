<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'flower_id',
        'total_amount',
        'pending',
        'shipping_address',
        'quantity',
        'is_delivered',
        'is_cancelled',
        'is_confirmed',
        'notify_cancel',
        'notify_delivery',
        'cancel_reason',
    ];

    // Order.php
    public function flower()
    {
        return $this->belongsTo(Flower::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
