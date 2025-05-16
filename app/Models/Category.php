<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $table = 'category';
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'sort_order',
        'image',
        'description',
        'created_by',
        'updated_by',
        'status'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
