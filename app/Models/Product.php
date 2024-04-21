<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'supplier_id', // Assurez-vous que vous avez un modèle Supplier correspondant.
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the supplier that provides the product.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class); // Assurez-vous d'avoir un modèle Supplier défini.
    }

    // Si vous avez d'autres relations ou des fonctionnalités spécifiques, ajoutez-les ici.
}
