<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    //
    use SoftDeletes;

    protected $table = 'product_categories';

    protected $fillable = ['name', 'description'];
    
    public function products():HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function order_items():HasMany
    {
        return $this->hasMany(OrderItem::class, 'category_id');
    }
}