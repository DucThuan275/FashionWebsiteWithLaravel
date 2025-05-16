<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'product';

    // Quan hệ với danh mục (category)
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Quan hệ với thương hiệu (brand)
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    // Quan hệ với orderdetail (sản phẩm có trong nhiều đơn hàng)
    public function orderdetails(): HasMany
    {
        return $this->hasMany(Orderdetail::class, 'product_id', 'id');
    }
}
