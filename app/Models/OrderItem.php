<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    //
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
    
    public function showOrTrack($order_id)
    {
        // Find the order by its ID, with related items and products, and address
        $order = Order::with('items.product', 'user.address')->findOrFail($order_id);

        // Check if it's a tracking route
        $isTracking = request()->routeIs('order.track');

        return view('order-detail', compact('order', 'isTracking')); // Pass order data and tracking flag
    }


}
