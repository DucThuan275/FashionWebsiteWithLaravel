<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;  // Uncomment if you want to use SoftDeletes
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;  // Add SoftDeletes if you're using it

    // Explicitly set the table name
    protected $table = 'user';  // Update this to match your table name

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'fullname',
        'email',
        'password',
        'gender',
        'thumbnail',
        'phone',
        'address',
        'roles',
        'status'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',   // You can use this if your email_verified_at column exists
        'password' => 'hashed',  // This ensures the password is hashed correctly
    ];

    // Optional: If using soft deletes, you may need to set the deleted_at column
    protected $dates = ['deleted_at']; // Add deleted_at for soft deletes (if you're using it)
}
