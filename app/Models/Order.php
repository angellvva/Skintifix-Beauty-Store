<?php

namespace App\Models;
use App\Models\Payments;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payments::class);
    }

    // Order.php
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

}
