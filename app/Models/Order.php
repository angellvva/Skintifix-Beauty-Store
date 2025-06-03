<?php

namespace App\Models;
use App\Models\Payments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    //
    use Hasfactory;
    protected $fillable = [
        'order_id',
        'user_id',
        'recipient_name',
        'recipient_phone',
        'recipient_address',
        'subtotal',
        'shipping_price',
        'total_amount',
        'status',
        'payment_url',
        'order_date'
    ];

    public $timestamps = true;

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
