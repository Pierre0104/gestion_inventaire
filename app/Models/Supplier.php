<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'contact_name',
        'email',
        'phone',
        'address'
    ];

 
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    // Assuming a supplier can supply many products
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Add more methods if you have other relationships
}
