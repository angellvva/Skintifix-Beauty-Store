<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    // Nama tabel jika tidak sesuai konvensi Laravel
    protected $table = 'products';

    // Kolom yang boleh diisi secara mass-assignment
    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'stock',
        'category_id',
    ];
    
    public function category():BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function order_items():HasMany
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    public function reviews()
{
    return $this->hasMany(Review::class);
}
}
