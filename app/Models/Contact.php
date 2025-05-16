<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    protected $table = 'contact';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'title',
        'content',
        'user_id',
        'created_by',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
