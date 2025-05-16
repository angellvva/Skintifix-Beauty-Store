<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    //
    public function product_category():BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function order_items():HasMany
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }
}
