<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;
    public $timestamps = true;
    protected $table = 'brand';
    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'sort_order',
        'created_by',
        'status'
    ];

    // Define relationship with the Product model
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
