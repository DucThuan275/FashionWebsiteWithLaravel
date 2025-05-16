<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orderdetail extends Model
{
    protected $table = 'orderdetail';
    public $timestamps = false;

    // Liên kết với bảng orders
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Liên kết với bảng products thông qua product_id
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
